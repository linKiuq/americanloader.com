#!/usr/bin/env bash

# Simple deployment script for Hostinger using expect
# On macOS, expect is usually pre-installed

SSH_USER="u534600013"
SSH_HOST="194.164.64.89"
SSH_PORT="65002"
APP_ROOT="/home/u534600013/laravel"
WEB_ROOT="/home/u534600013/public_html"
GITHUB_REPO="https://github.com/linKiuq/americanloader.com.git"
BRANCH="main"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🌐 Hostinger Deployment"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check if expect is installed
if ! command -v expect &> /dev/null; then
    echo "❌ 'expect' is not installed"
    echo "Install with: sudo port install expect"
    exit 1
fi

# Create expect script
cat > /tmp/deploy_expect.sh << 'EXPECTSCRIPT'
#!/usr/bin/expect -f

set timeout 30
set user [lindex $argv 0]
set host [lindex $argv 1]
set port [lindex $argv 2]
set password [lindex $argv 3]
set app_root [lindex $argv 4]
set web_root [lindex $argv 5]
set github_repo [lindex $argv 6]
set branch [lindex $argv 7]

spawn ssh -p $port $user@$host

expect "password:"
send "$password\r"

expect "$"

send "set -e\r"
send "APP_ROOT=\"$app_root\"\r"
send "WEB_ROOT=\"$web_root\"\r"
send "GITHUB_REPO=\"$github_repo\"\r"
send "BRANCH=\"$branch\"\r"

send "echo '📁 Checking repository...'\r"
send "if \[ -d \"\$APP_ROOT/.git\" \]; then\r"
send "  cd \$APP_ROOT\r"
send "  git fetch origin\r"
send "  git checkout \$BRANCH\r"
send "  git pull origin \$BRANCH\r"
send "else\r"
send "  rm -rf \"\$APP_ROOT\" 2>/dev/null || true\r"
send "  git clone -b \$BRANCH \$GITHUB_REPO \"\$APP_ROOT\"\r"
send "  cd \$APP_ROOT\r"
send "fi\r"

send "echo '📦 Installing dependencies...'\r"
send "if command -v composer &> /dev/null; then\r"
send "  composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || true\r"
send "else\r"
send "  echo '⚠️  Composer not found'\r"
send "fi\r"

send "echo '🔐 Setting permissions...'\r"
send "chmod -R 755 \"\$APP_ROOT/storage\" \"\$APP_ROOT/bootstrap/cache\" 2>/dev/null || true\r"
send "chmod -R 777 \"\$APP_ROOT/storage\" \"\$APP_ROOT/bootstrap/cache\" 2>/dev/null || true\r"

send "echo '🔗 Updating web root...'\r"
send "if [ -L \"\$WEB_ROOT\" ]; then rm -f \"\$WEB_ROOT\"; fi\r"
send "if [ -d \"\$WEB_ROOT\" ]; then rm -rf \"\$WEB_ROOT\" 2>/dev/null || true; fi\r"
send "if ln -s \"\$APP_ROOT/public\" \"\$WEB_ROOT\"; then echo '✅ Webroot linked'; else mkdir -p \"\$WEB_ROOT\"; cp -R \"\$APP_ROOT/public/.\" \"\$WEB_ROOT/\"; fi\r"

send "echo '🧩 Linking storage...'\r"
send "if command -v php &> /dev/null; then\r"
send "  cd \$APP_ROOT\r"
send "  php artisan storage:link || true\r"
send "fi\r"

send "echo '✅ Deployment complete!'\r"
send "exit\r"

expect eof
EXPECTSCRIPT

chmod +x /tmp/deploy_expect.sh

# Prompt for password
read -sp "Enter SSH password: " PASSWORD
echo ""

echo "Starting deployment..."
expect /tmp/deploy_expect.sh "$SSH_USER" "$SSH_HOST" "$SSH_PORT" "$APP_ROOT" "$WEB_ROOT" "$GITHUB_REPO" "$BRANCH"

if [ $? -eq 0 ]; then
    echo "✅ Deployment successful!"
else
    echo "❌ Deployment failed!"
    exit 1
fi

# Cleanup
rm -f /tmp/deploy_expect.sh
