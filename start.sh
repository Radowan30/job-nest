#!/usr/bin/env sh
set -e

echo "🔄 Running migrations..."
php artisan migrate --force

echo "🚀 Starting PHP‑FPM & Nginx"

