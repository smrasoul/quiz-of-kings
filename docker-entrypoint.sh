#!/bin/bash
set -e

# Create required directories if they don't exist
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/bootstrap/cache

# Allow PHP-FPM (www-data) to modify storage and cache directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create symbolic link for storage
php artisan storage:link

# Generate application key if it doesn't exist
if [ -z "$(grep '^APP_KEY=' .env | grep -v '=$')" ]; then
    php artisan key:generate
fi

# Run migrations if the database is ready
if [ "$DB_HOST" != "" ]; then
    # Wait for the database to be ready
    until nc -z -v -w30 $DB_HOST 3306; do
      echo "Waiting for database connection..."
      # Wait for 5 seconds before check again
      sleep 5
    done

    php artisan migrate --seed
fi

#to solve the laravel.log problem
mkdir -p /var/www/html/storage/logs
touch /var/www/html/storage/logs/laravel.log
chown www-data:www-data /var/www/html/storage/logs/laravel.log
chmod 775 /var/www/html/storage/logs/laravel.log

# Run migrations and seed database if the container is starting fresh
echo "Running database migrations and seeding..."
php artisan migrate:fresh --seed

#to solve the manifest problem
echo "Building frontend assets..."
npm install
npm run build

# Execute the provided command (which is typically php-fpm)
exec "$@"
