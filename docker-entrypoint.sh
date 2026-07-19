#!/bin/bash
set -e

# APP_KEY must be set as an Environment Variable in the Render dashboard
# (there is no .env file inside this container, so artisan key:generate would fail here)

# Cache config, routes, and views for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically on deploy
php artisan migrate --force

# Hand off to the main container command (apache2-foreground)
exec "$@"