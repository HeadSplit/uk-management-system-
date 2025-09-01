FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
        libpq-dev \
        libzip-dev \
        zip \
        git curl \
        libonig-dev \
        libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

RUN apt-get update && apt-get install -y bash

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

LABEL authors="P1ll0w"

CMD ["php-fpm"]

