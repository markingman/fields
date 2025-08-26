ARG PHP_VERSION=8.3
ARG COMPOSER_VERSION=2.8.1
ARG XDEBUG_VERSION=3.4.2

FROM php:${PHP_VERSION}-alpine AS base
ARG XDEBUG_VERSION

RUN set -eux; \
    apk add --update --no-cache unzip linux-headers curl $PHPIZE_DEPS; \
    pecl channel-update pecl.php.net; \
    pecl install xdebug-${XDEBUG_VERSION}; \
    docker-php-ext-enable xdebug; \
    docker-php-ext-install mbstring \
    pecl clear-cache

RUN printf '%s\n' \
    'xdebug.mode=coverage' \
    'xdebug.start_with_request=yes' \
    'xdebug.client_host=host.docker.internal' \
    'xdebug.client_port=9003' \
    > /usr/local/etc/php/conf.d/99-xdebug.ini

FROM composer:${COMPOSER_VERSION} AS composer

FROM base

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
RUN /usr/bin/composer install --no-interaction --prefer-dist --no-progress
