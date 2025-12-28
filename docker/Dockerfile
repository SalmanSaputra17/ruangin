FROM php:8.3-fpm-alpine

ARG NODE_VERSION=20

RUN apk update && apk add --no-cache \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    mariadb-client \
    nodejs-current \
    npm \
    git \
    unzip \
    bash \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 9000

# RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
