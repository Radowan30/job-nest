#!/usr/bin/env sh
set -e

# Run migrations only once per container lifecycle
if [ ! -f /tmp/.migrations_done ]; then
  echo "🔄 Running database migrations..."
  php artisan migrate --force
  touch /tmp/.migrations_done
else
  echo "✅ Migrations already applied."
fi

# S6 will automatically start Nginx and PHP-FPM — no need to exec anything
echo "🚀 Starting services (via S6)..."
