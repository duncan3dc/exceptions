ARG PHP_VERSION=7.2
FROM php:${PHP_VERSION}-cli

RUN apt update && apt install -y git zip
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
