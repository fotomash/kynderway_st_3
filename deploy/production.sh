#!/usr/bin/env bash
set -e

# Move to project root
cd "$(dirname "$0")/.."

# Pull latest changes from main branch
git fetch origin
git checkout main
git pull origin main

# Install PHP dependencies without development packages
composer install --no-dev --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
php artisan queue:restart

# Restart PHP-FPM service
sudo systemctl restart php-fpm

