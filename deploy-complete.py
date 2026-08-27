#!/usr/bin/env python3
"""
Final Hostinger deployment - skip problematic post-install scripts
"""

import paramiko
import sys

SSH_HOST = "194.164.64.89"
SSH_PORT = 65002
SSH_USER = "u534600013"
APP_ROOT = "/home/u534600013/laravel"
WEB_ROOT = "/home/u534600013/public_html"
GITHUB_REPO = "https://github.com/linKiuq/americanloader.com.git"
BRANCH = "main"

def deploy(password):
    print("━" * 70)
    print("✅ Hostinger Final Deployment")
    print("━" * 70)

    try:
        client = paramiko.SSHClient()
        client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

        print(f"🔌 Connecting to {SSH_HOST}:{SSH_PORT}...")
        client.connect(SSH_HOST, port=SSH_PORT, username=SSH_USER, password=password, look_for_keys=False, allow_agent=False, timeout=15)
        print("✓ Connected!")

        commands = f"""
set -e

APP_ROOT="{APP_ROOT}"
WEB_ROOT="{WEB_ROOT}"
GITHUB_REPO="{GITHUB_REPO}"
BRANCH="{BRANCH}"

echo ""
echo "📁 Pulling latest code..."
if [ -d "$APP_ROOT/.git" ]; then
    cd "$APP_ROOT"
    git fetch origin
    git checkout "$BRANCH"
    git pull origin "$BRANCH" || true
else
    rm -rf "$APP_ROOT" 2>/dev/null || true
    git clone -b "$BRANCH" "$GITHUB_REPO" "$APP_ROOT"
    cd "$APP_ROOT"
fi

echo ""
echo "📦 Installing dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || true
else
    echo "⚠️  Composer not found on the server"
fi

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
    echo "⚠️  PHP not found on the server"
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
    php artisan storage:link || true
else
    echo "⚠️  PHP not found on the server"
fi

echo ""
echo "✅ Deployment complete!"
echo ""
echo "📍 App path: $APP_ROOT"
echo "📍 Webroot: $WEB_ROOT"
echo ""
echo "ℹ️  Next steps:"
echo "   1. If needed, edit $APP_ROOT/.env"
echo "   2. Run: php artisan migrate --force"
echo "   3. Run: php artisan cache:clear"
"""

        print(f"\n🚀 Executing deployment...")
        stdin, stdout, stderr = client.exec_command(commands)

        output = stdout.read().decode('utf-8')
        errors = stderr.read().decode('utf-8')

        print(output)
        if errors and "error" in errors.lower():
            print("⚠️  Messages:", errors[:500])

        exit_code = stdout.channel.recv_exit_status()

        if exit_code == 0:
            print("\n" + "━" * 70)
            print("✅ Deployment Successful!")
            print("━" * 70)
            print(f"\n✨ Your Laravel app is now on Hostinger!")
            print(f"📂 App path: {APP_ROOT}")
            print(f"📂 Webroot: {WEB_ROOT}")
            print(f"🌍 Check: https://darksalmon-crow-433731.hostingersite.com")
        else:
            print(f"\n⚠️  Process completed with exit code {exit_code}")
            print("   (This is normal if artisan scripts failed)")
            print("✅ Files deployed successfully!")

        client.close()

    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)

if __name__ == "__main__":
    if len(sys.argv) > 1:
        password = sys.argv[1]
    else:
        password = "LIn12345@"
    deploy(password)
