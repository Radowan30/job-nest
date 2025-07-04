#!/usr/bin/env sh
set -e

echo "🔄 Running migrations (once)…"
php artisan migrate --force

echo "✅ Migrations complete."
# Return instead of exit to allow S6 to continue
return 0
