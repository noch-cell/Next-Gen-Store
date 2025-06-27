#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

# Change to the application directory
cd /var/www/html

# Check if vendor directory exists and run composer install if not
if [ ! -d "vendor" ]; then
    echo "Running composer install..."
    composer install
else
    echo "vendor directory already exists.
fi

# If not, generate it. This is crucial for Laravel's security features.
if grep -qE '^APP_KEY=\s*$' .env || ! grep -q '^APP_KEY=' .env; then
    echo "Generating application key..."
    php artisan key:generate
else
    echo "Application key already exists."
fi

# if [ ! -f .env ]; then
#     cp .env.example .env
# fi

# php artisan key:generate --force

# Check if node_modules directory exists and run npm install if not
if [ ! -d "node_modules" ]; then
    echo "Running npm install..."
    npm install
else
    echo "node_modules directory already exists.
fi

# Run npm build if node_modules exists, to compile assets.
if [ -d "node_modules" ]; then
    echo "Running npm run build..."
    npm run build
else
    echo "node_modules not found, skipping npm run build."
fi

# Run Laravel migrations.
echo "Running Laravel migrations..."
php artisan migrate --seed

# Clear and cache Laravel configurations
echo "Clearing and caching Laravel configurations..."

chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
# Execute the main command passed to the script (e.g., "php-fpm").
exec "$@"
