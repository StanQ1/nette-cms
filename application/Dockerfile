FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libzip-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl fileinfo \
    && apt-get clean

RUN mkdir -p ./application/temp ./application/log \
    && chmod -R 775 ./application/temp \
    && chmod -R 775 ./application/log \