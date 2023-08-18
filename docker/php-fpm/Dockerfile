FROM php:8.1-fpm-alpine

RUN apk --no-cache update \
    && apk add --no-cache autoconf g++ make freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev \
    postgresql-dev \
    icu-dev \
    \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql\
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg && \
    docker-php-ext-install gd
