#!/bin/bash
set -e

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🚀 Auto Push & Deploy to Hostinger (americanloader.com)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

echo ""
echo "📤 Step 1: Pushing changes to GitHub..."
git push upstream main 2>/dev/null || git push origin main

echo ""
echo "🔌 Step 2: Connecting to Hostinger & Deploying..."

export SSHPASS='LIn12345@'

sshpass -e ssh -p 65002 -o StrictHostKeyChecking=no u534600013@194.164.64.89 << 'REMOTE'
  set -e

  PHP_BIN="/opt/alt/php84/usr/bin/php"
  if [ ! -f "$PHP_BIN" ]; then
    PHP_BIN="php"
  fi

  # Determine target directory
  if [ -d "/home/u534600013/domains/americanloader.com/public_html" ]; then
    APP_PATH="/home/u534600013/domains/americanloader.com/public_html"
  elif [ -d "/home/u534600013/laravel" ]; then
    APP_PATH="/home/u534600013/laravel"
  else
    APP_PATH="/home/u534600013/public_html"
  fi

  echo "📍 Working directory: $APP_PATH"
  cd "$APP_PATH"

  echo "📥 Pulling latest main branch from GitHub..."
  git fetch --prune origin
  git reset --hard origin/main || git pull origin main

  echo "🗄️  Running database migrations..."
  $PHP_BIN artisan migrate --force || true

  echo "🧹 Clearing & optimizing cache..."
  $PHP_BIN artisan optimize:clear || true
  $PHP_BIN artisan config:clear || true
  $PHP_BIN artisan cache:clear || true

  echo ""
  echo "✅ Hostinger Deployment Successful!"
REMOTE

echo ""
echo "🎉 ALL DONE! Your site is live at https://americanloader.com"
