#!/usr/bin/env python3
"""
Deployment script for Hostinger using paramiko SSH library
"""

import subprocess
import sys
import os
import getpass

# Configuration
SSH_USER = "u534600013"
SSH_HOST = "194.164.64.89"
SSH_PORT = 65002
APP_ROOT = "/home/u534600013/laravel"
WEB_ROOT = "/home/u534600013/public_html"
GITHUB_REPO = "https://github.com/linKiuq/americanloader.com.git"
BRANCH = "main"

def run_command(cmd, description):
    """Run a shell command"""
    print(f"\n{'='*60}")
    print(f"→ {description}")
    print(f"{'='*60}")
    result = subprocess.run(cmd, shell=True)
    if result.returncode != 0:
        print(f"❌ Failed: {description}")
        sys.exit(1)
    print(f"✓ {description}")

def deploy(password):
    """Execute deployment"""

    # SSH command with deployment steps
    ssh_command = f"""sshpass -p '{password}' ssh -o StrictHostKeyChecking=no -p {SSH_PORT} {SSH_USER}@{SSH_HOST} << 'DEPLOY'
set -e

APP_ROOT="{APP_ROOT}"
WEB_ROOT="{WEB_ROOT}"
GITHUB_REPO="{GITHUB_REPO}"
BRANCH="{BRANCH}"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🚀 Deployment Started"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Connected to: $(whoami)@$(hostname)"
echo "App path: $APP_ROOT"
echo "Webroot: $WEB_ROOT"
echo ""

# Check if repo exists
if [ -d "$APP_ROOT/.git" ]; then
    echo "📥 Pulling latest code..."
    cd "$APP_ROOT"
    git fetch origin
    git checkout $BRANCH
    git pull origin $BRANCH
else
    echo "📁 Cloning repository..."
    rm -rf "$APP_ROOT" 2>/dev/null || true
    git clone -b $BRANCH $GITHUB_REPO "$APP_ROOT"
    cd "$APP_ROOT"
fi

# Install/update dependencies
echo ""
echo "📦 Installing PHP dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || true
else
    echo "⚠️  Composer not found - skipping"
fi

# Set permissions
echo ""
echo "📝 Ensuring .env exists..."
if [ ! -f "$APP_ROOT/.env" ]; then
    if [ -f "$APP_ROOT/.env.example" ]; then
        cp "$APP_ROOT/.env.example" "$APP_ROOT/.env"
    else
        touch "$APP_ROOT/.env"
    fi
fi

cd "$APP_ROOT"
if command -v php &> /dev/null; then
    php artisan key:generate --force || true
else
    echo "⚠️  PHP not found; skipping key generation"
fi

echo ""
echo "🔐 Setting permissions..."
chmod -R 755 "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache" 2>/dev/null || true
chmod -R 777 "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache" 2>/dev/null || true

echo ""
echo "🔗 Updating web root..."
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

echo ""
echo "🧩 Linking storage..."
if command -v php &> /dev/null; then
    cd "$APP_ROOT"
    php artisan storage:link || true
else
    echo "⚠️  PHP not found; skipping storage link"
fi

# Run migrations if .env exists
if [ -f ".env" ]; then
    echo ""
    echo "🗄️  Running database migrations..."
    php artisan migrate --force || echo "⚠️  Migration skipped"

    echo "🧹 Clearing cache..."
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ Deployment completed successfully!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

DEPLOY
"""

    # First check if sshpass is available
    check_sshpass = subprocess.run("which sshpass", shell=True, capture_output=True)

    if check_sshpass.returncode != 0:
        print("⚠️  sshpass not found - Installing via MacPorts...")
        run_command("sudo port install sshpass", "Install sshpass")

    run_command(ssh_command, "Deploy to Hostinger")

if __name__ == "__main__":
    print("\n" + "="*60)
    print("🌐 Hostinger Deployment Script")
    print("="*60)

    # Get password
    password = getpass.getpass(f"Enter SSH password for {SSH_USER}: ")

    if not password:
        print("❌ Password required!")
        sys.exit(1)

    try:
        deploy(password)
    except KeyboardInterrupt:
        print("\n❌ Deployment cancelled by user")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)
