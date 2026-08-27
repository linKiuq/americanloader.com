#!/usr/bin/env python3
"""
Deploy using SCP to copy vendor folder directly
"""

import paramiko
import os
import sys

SSH_HOST = "194.164.64.89"
SSH_PORT = 65002
SSH_USER = "u534600013"
APP_ROOT = "/home/u534600013/laravel"
WEB_ROOT = "/home/u534600013/public_html"
GITHUB_REPO = "https://github.com/linKiuq/americanloader.com.git"
BRANCH = "main"
LOCAL_VENDOR = "/Users/bosreylin/skoop-loaders/vendor"

def deploy(password):
    print("━" * 70)
    print("🚀 Hostinger Deployment with Pre-compiled Vendor")
    print("━" * 70)

    try:
        # Create SSH client
        client = paramiko.SSHClient()
        client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

        print(f"🔌 Connecting to {SSH_HOST}:{SSH_PORT}...")
        client.connect(SSH_HOST, port=SSH_PORT, username=SSH_USER, password=password, timeout=10)
        print("✓ Connected!")

        # Step 1: Pull latest code
        print("\n📁 Pulling latest code from GitHub...")
        commands = f"""
set -e

APP_ROOT="{APP_ROOT}"
WEB_ROOT="{WEB_ROOT}"
GITHUB_REPO="{GITHUB_REPO}"
BRANCH="{BRANCH}"

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

echo ""
echo "📦 Installing dependencies (ignore platform requirements)..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || true
else
    echo "⚠️  Composer not found"
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
echo "✅ Code checkout complete!"
"""
        stdin, stdout, stderr = client.exec_command(commands)
        output = stdout.read().decode('utf-8')
        print(output)

        client.close()

        # Step 2: Upload vendor folder via SCP
        print("\n📦 Uploading vendor folder via SCP...")
        print(f"Local: {LOCAL_VENDOR}")
        print(f"Remote: {APP_ROOT}/vendor")

        # Create SSH transport for SCP
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect(SSH_HOST, port=SSH_PORT, username=SSH_USER, password=password, timeout=30)
        sftp = ssh.open_sftp()

        # Upload vendor recursively
        def upload_dir(sftp, local_path, remote_path):
            for item in os.listdir(local_path):
                local_item = os.path.join(local_path, item)
                remote_item = f"{remote_path}/{item}"

                if os.path.isdir(local_item):
                    try:
                        sftp.mkdir(remote_item)
                    except IOError:
                        pass
                    upload_dir(sftp, local_item, remote_item)
                else:
                    print(f"  Uploading: {remote_item}")
                    sftp.put(local_item, remote_item)

        upload_dir(sftp, LOCAL_VENDOR, f"{APP_ROOT}/vendor")
        sftp.close()
        ssh.close()

        print("\n✅ Deployment successful!")

    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)

if __name__ == "__main__":
    password = "Hustinger@12"
    deploy(password)
