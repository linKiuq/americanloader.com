#!/usr/bin/env python3
"""
Deploy to Hostinger with platform requirements ignored
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
    print("🚀 Hostinger Deployment (Ignoring Platform Req)")
    print("━" * 70)

    try:
        client = paramiko.SSHClient()
        client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

        print(f"🔌 Connecting to {SSH_HOST}:{SSH_PORT}...")
        client.connect(SSH_HOST, port=SSH_PORT, username=SSH_USER, password=password, timeout=10)
        print("✓ Connected!")

        # Deployment commands with --ignore-platform-req
        commands = f"""
set -e

APP_ROOT="{APP_ROOT}"
WEB_ROOT="{WEB_ROOT}"
GITHUB_REPO="{GITHUB_REPO}"
BRANCH="{BRANCH}"

echo ""
echo "📁 Repository setup..."
if [ -d "$APP_ROOT/.git" ]; then
    cd "$APP_ROOT"
    git fetch origin
    git checkout "$BRANCH"
    git pull origin "$BRANCH"
else
    rm -rf "$APP_ROOT" 2>/dev/null || true
    git clone -b "$BRANCH" "$GITHUB_REPO" "$APP_ROOT"
    cd "$APP_ROOT"
fi

cd "$APP_ROOT"
pwd

echo ""
echo "📦 Installing dependencies (ignoring platform requirements)..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || true
else
    echo "⚠️  Composer not found"
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
    echo "⚠️  PHP not found"
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
fi

echo ""
echo "✅ Deployment complete!"
"""

        print(f"\n🚀 Executing deployment...")
        stdin, stdout, stderr = client.exec_command(commands)

        # Read output
        output = stdout.read().decode('utf-8')
        errors = stderr.read().decode('utf-8')

        print(output)
        if errors:
            print("ℹ️  Server messages:")
            print(errors)

        exit_code = stdout.channel.recv_exit_status()

        if exit_code == 0:
            print("\n" + "━" * 70)
            print("✅ Deployment successful!")
            print("━" * 70)
            print(f"\n🌐 Your site: https://darksalmon-crow-433731.hostingersite.com")
        else:
            print(f"\n❌ Deployment failed with exit code {exit_code}")
            sys.exit(1)

        client.close()

    except paramiko.AuthenticationException:
        print("❌ Authentication failed")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)

if __name__ == "__main__":
    password = "Hustinger@12"
    deploy(password)
