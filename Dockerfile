FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && \
    apt-get install -y git unzip zip libzip-dev curl && \
    docker-php-ext-install pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

WORKDIR /var/www

COPY . /var/www

RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    npm install && npm run prod

CMD ["php-fpm"]
