#!/bin/bash
set -e

# Generate app key if not already set (safe to run every time; Laravel skips if already set in .env)
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache config, routes, and views for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically on deploy
php artisan migrate --force

# Hand off to the main container command (apache2-foreground)
exec "$@"