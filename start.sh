#!/usr/bin/env bash
set -e
echo "🔄 Running migrations..."
php artisan migrate --force
echo "🚀 Starting PHP-FPM & Nginx..."
exec /usr/bin/supervisord -n
