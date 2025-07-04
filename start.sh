#!/usr/bin/env bash
set -e
echo "🔄 Running migrations..."
php artisan migrate --force
echo "🚀 Launching PHP‑FPM & Nginx via supervisord..."
exec /usr/bin/supervisord -n
