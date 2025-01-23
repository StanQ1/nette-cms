FROM php:8.2-fpm
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y libzip-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl fileinfo \
    && apt-get clean