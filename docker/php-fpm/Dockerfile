FROM php:8.1-fpm-alpine

RUN apk --no-cache update \
    && apk add --no-cache autoconf g++ make \
    postgresql-dev \
    icu-dev \
    \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql\
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl
