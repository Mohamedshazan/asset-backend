FROM php:8.2-fpm-bullseye

RUN sed -i 's|http://deb.debian.org|https://deb.debian.org|g' /etc/apt/sources.list \
    && apt-get update \
    && apt-get install -y \
        zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
