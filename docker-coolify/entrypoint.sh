
#!/bin/sh
set -e

cd /var/www

echo "Rebuilding Laravel configuration cache..."
php artisan config:clear
php artisan config:cache

echo "Running Laravel database migrations..."
php artisan migrate --force

echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
