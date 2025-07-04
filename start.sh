#!/usr/bin/env bash
set -e
echo "🔄 Running migrations..."
php artisan migrate --force
echo "🚀 Launching PHP-FPM..."
exec php-fpm
