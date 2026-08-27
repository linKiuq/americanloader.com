#!/bin/bash

# Deployment script for Hostinger
# Configure these variables before running:

SSH_USER="u534600013"
SSH_HOST="194.164.64.89"
SSH_PORT="65002"
SSH_PASSWORD="${SSH_PASSWORD:-}"  # Set via environment variable or prompt
APP_ROOT="/home/u534600013/laravel"
WEB_ROOT="/home/u534600013/public_html"
GITHUB_REPO="https://github.com/linKiuq/americanloader.com.git"
BRANCH="main"

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if sshpass is installed
if ! command -v sshpass &> /dev/null; then
    echo -e "${RED}sshpass is not installed. Installing...${NC}"
    if command -v brew &> /dev/null; then
        brew install sshpass
    elif command -v port &> /dev/null; then
        sudo port install sshpass
    else
        echo -e "${RED}Error: sshpass is required but neither brew nor MacPorts is available.${NC}"
        echo "Please install sshpass manually or install Homebrew/MacPorts first."
        exit 1
    fi
fi

echo -e "${YELLOW}Starting deployment to Hostinger...${NC}"

# Prompt for password if not set
if [ -z "$SSH_PASSWORD" ]; then
    read -sp "Enter SSH password for $SSH_USER: " SSH_PASSWORD
    echo ""
fi

# Step 1: Connect and deploy
echo -e "${YELLOW}Step 1: Connecting to Hostinger and deploying...${NC}"

sshpass -p "$SSH_PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $SSH_USER@$SSH_HOST << 'ENDSSH'
set -e

# Define paths
APP_ROOT="/home/u534600013/laravel"
WEB_ROOT="/home/u534600013/public_html"
GITHUB_REPO="https://github.com/linKiuq/americanloader.com.git"
BRANCH="main"

echo "Connected to server"
echo "Current user: $(whoami)"
echo "Current directory: $(pwd)"

echo "App path: $APP_ROOT"
echo "Webroot: $WEB_ROOT"

# Check if repo exists
if [ -d "$APP_ROOT/.git" ]; then
    echo "Pulling latest code..."
    cd "$APP_ROOT"
    git fetch origin
    git checkout $BRANCH
    git pull origin $BRANCH
else
    echo "Cloning repository..."
    rm -rf "$APP_ROOT" 2>/dev/null || true
    git clone -b $BRANCH $GITHUB_REPO "$APP_ROOT"
    cd "$APP_ROOT"
fi

# Install/update dependencies
echo "Installing PHP dependencies with Composer..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || true
else
    echo "Composer not found. Please install Composer on the server."
fi

# Set permissions
echo "Setting permissions..."
chmod -R 755 "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache"
chmod -R 777 "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache"

echo "Updating web root..."
if [ -L "$WEB_ROOT" ]; then
    rm -f "$WEB_ROOT"
fi
if [ -d "$WEB_ROOT" ]; then
    rm -rf "$WEB_ROOT" 2>/dev/null || true
fi
if ln -s "$APP_ROOT/public" "$WEB_ROOT"; then
    echo "✅ Webroot linked"
else
    echo "⚠️  Symlink failed; copying public files instead"
    mkdir -p "$WEB_ROOT"
    cp -R "$APP_ROOT/public/." "$WEB_ROOT/"
fi

echo "Ensuring .env exists..."
if [ ! -f "$APP_ROOT/.env" ]; then
    if [ -f "$APP_ROOT/.env.example" ]; then
        cp "$APP_ROOT/.env.example" "$APP_ROOT/.env"
    else
        touch "$APP_ROOT/.env"
    fi
fi

if command -v php &> /dev/null; then
    cd "$APP_ROOT"
    php artisan key:generate --force || true
    php artisan storage:link || true
else
    echo "⚠️  PHP not found; skipping key generation and storage link"
fi

# Run migrations if .env exists
if [ -f "$APP_ROOT/.env" ]; then
    echo "Running database migrations..."
    cd "$APP_ROOT"
    php artisan migrate --force
    echo "Clearing cache..."
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
fi

echo "Deployment completed successfully!"

ENDSSH

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Deployment completed successfully!${NC}"
else
    echo -e "${RED}✗ Deployment failed!${NC}"
    exit 1
fi
