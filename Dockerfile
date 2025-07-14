# syntax=docker/dockerfile:1
############################
# 1️⃣  Composer build – vendor/
############################
FROM composer:2.7 AS vendor

# Extensions needed for composer scripts
RUN apk add --no-cache icu-dev oniguruma-dev libzip-dev \
 && docker-php-ext-install intl pdo_mysql zip

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts
COPY . .

############################
# 2️⃣  Node build – front-end assets
############################
FROM node:18-alpine AS nodebuilder
WORKDIR /app
COPY --from=vendor /app /app

# Tools for native modules (if you hit node-gyp errors)
RUN apk add --no-cache --virtual .gyp python3 make g++

RUN npm ci --no-progress --silent \
 && npm run production      # or npm run build / vite build etc.

############################
# 3️⃣  Runtime – slim PHP-FPM
############################
FROM php:8.2-fpm-alpine

RUN apk add --no-cache oniguruma libzip icu-libs

WORKDIR /var/www

# Copy backend (code + vendor) and compiled front-end
COPY --from=vendor      /app           /var/www
COPY --from=nodebuilder /app/public    /var/www/public

# Entrypoint: run artisan optimisations once
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh \
 && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

HEALTHCHECK --interval=30s --timeout=3s CMD php -r "echo 'OK';"
EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]

############################
# 3️⃣  Runtime – slim Alpine
############################
RUN npm ci && npm run build

# Needed libs (runtime only)
RUN apk add --no-cache oniguruma libzip icu-libs

WORKDIR /var/www

# Copy backend (incl. vendor) & compiled front-end
COPY --from=vendor      /app           /var/www
COPY --from=nodebuilder /app/public    /var/www/public

# Entrypoint runs optimisation once container starts
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && \
    chown -R www-data/:www-data /var/www/storage /var/www/bootstrap/cache
HEALTHCHECK --interval=30s --timeout=3s CMD php -r "echo 'OK';"

EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]