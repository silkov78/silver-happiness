FROM php:8.0-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# COPY ./project/php.ini /usr/local/etc/php/php.ini

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git curl

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www
