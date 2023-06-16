# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.2
FROM wordpress:php${PHP_VERSION}-apache

RUN apt-get update && docker-php-ext-install \
    mysqli \
    pdo_mysql \
    && apt-get install -y --no-install-recommends \
    wget \
    vim

RUN wget https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 && \
    chmod +x mhsendmail_linux_amd64 && \
    mv mhsendmail_linux_amd64 /usr/bin/mhsendmail && \
    echo 'sendmail_path = "/usr/bin/mhsendmail --smtp-addr=email:1025"' > /usr/local/etc/php/php.ini
