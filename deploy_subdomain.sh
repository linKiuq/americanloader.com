#!/bin/bash
export SSHPASS='LIn12345@'

echo "Deploying directly to Hostinger Domain americanloader.com..."

sshpass -e ssh -p 65002 -o StrictHostKeyChecking=no u534600013@194.164.64.89 << 'REMOTE'
  set -e
  echo "Connected to Hostinger Server!"
  
  SUBDOMAIN_ROOT="/home/u534600013/domains/americanloader.com/public_html"
  PHP_BIN="/opt/alt/php84/usr/bin/php"

  cd "$SUBDOMAIN_ROOT"

  echo "Fetching and resetting to origin/main..."
  git fetch --prune origin
  git reset --hard origin/main

  echo "Clearing optimization cache..."
  $PHP_BIN artisan optimize:clear

  echo "✅ Subdomain Deployment Complete!"
REMOTE
