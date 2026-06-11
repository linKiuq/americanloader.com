#!/bin/bash
export SSHPASS='LIn12345@'

echo "Deploying directly to Hostinger Domain skidsteers.org..."

sshpass -e ssh -p 65002 -o StrictHostKeyChecking=no u534600013@194.164.64.89 << 'REMOTE'
  set -e
  echo "Connected to Hostinger Server!"
  
  TARGET_ROOT="/home/u534600013/domains/skidsteers.org"
  PHP_BIN="/opt/alt/php84/usr/bin/php"
  REPO_URL="https://github.com/luusea76-bot/Wheel-Loader.git"
  BRANCH="main"

  # 1. Back up WordPress public_html if it hasn't been backed up yet
  if [ -d "$TARGET_ROOT/public_html" ] && [ ! -d "$TARGET_ROOT/public_html/.git" ] && [ -f "$TARGET_ROOT/public_html/wp-config.php" ]; then
    echo "Backing up existing WordPress public_html folder to public_html_backup_wp..."
    mv "$TARGET_ROOT/public_html" "$TARGET_ROOT/public_html_backup_wp"
  fi

  # 2. Create and enter public_html
  mkdir -p "$TARGET_ROOT/public_html"
  cd "$TARGET_ROOT/public_html"

  # 3. Clone or reset git repository
  if [ -d ".git" ]; then
    echo "Pulling latest code..."
    git remote set-url origin "$REPO_URL"
    git fetch --prune origin "$BRANCH"
    git reset --hard "origin/$BRANCH"
  else
    echo "Cloning repository..."
    git clone --branch "$BRANCH" "$REPO_URL" .
  fi

  # 4. Set up .env file
  if [ ! -f .env ]; then
    echo "Setting up .env file..."
    cp .env.example .env
    
    # Configure APP_URL
    sed -i 's|APP_URL=http://localhost|APP_URL=https://skidsteers.org|g' .env
    
    # Configure Database Connection (SQLite)
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/g' .env
    # Add sqlite db creation if not existing
    touch database/database.sqlite
  else
    # Ensure APP_URL is correctly set
    sed -i 's|APP_URL=http://localhost|APP_URL=https://skidsteers.org|g' .env
    touch database/database.sqlite
  fi

  # 5. Install PHP dependencies
  echo "Downloading composer..."
  if [ ! -f composer.phar ]; then
    wget -qO composer.phar https://getcomposer.org/download/latest-stable/composer.phar
  fi

  echo "Installing dependencies..."
  $PHP_BIN composer.phar install --no-dev --optimize-autoloader --no-interaction --no-scripts

  # 6. Generate APP_KEY if missing
  if ! grep -Eq '^APP_KEY=base64:.+' .env; then
    echo "Generating application key..."
    $PHP_BIN artisan key:generate --force
  fi

  # 7. Run migrations and discover packages
  echo "Running package discovery and migrations..."
  $PHP_BIN artisan package:discover --ansi
  $PHP_BIN artisan migrate --force || true
  $PHP_BIN artisan optimize:clear

  echo "✅ skidsteers.org Deployment Complete!"
REMOTE
