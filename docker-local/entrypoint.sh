#!/bin/sh
set -e

mkdir -p /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

if [ -f "/var/www/artisan" ]; then
    php artisan config:clear || true
    php artisan cache:clear || true

    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

exec "$@"