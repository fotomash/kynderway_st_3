#!/usr/bin/env sh
set -e

# Run once per container
php artisan package:discover   --ansi --no-interaction
php artisan config:cache       --no-interaction
php artisan route:cache        --no-interaction
php artisan view:cache         --no-interaction

exec "$@"
