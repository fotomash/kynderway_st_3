############################
# 1️⃣  Composer build – vendor/
############################
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

############################
# 2️⃣  Node build – front-end assets
############################
FROM node:18-alpine AS nodebuilder
WORKDIR /app
COPY package.json yarn.lock .yarnrc.yml ./
COPY .yarn ./.yarn
RUN corepack enable \
 && corepack prepare yarn@4.9.2 --activate \
 && yarn install --immutable --immutable-cache --silent
COPY resources ./resources
COPY vite.config.js tailwind.config.js ./
RUN yarn build

############################
# 3️⃣  Runtime – slim PHP-FPM
############################
FROM php:8.2-fpm-alpine
WORKDIR /var/www
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