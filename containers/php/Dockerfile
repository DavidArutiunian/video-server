FROM php:7.1-fpm

RUN mkdir -p /var/www/
WORKDIR /var/www/

RUN apt-get update && \
apt-get install -y --no-install-recommends git zip unzip libxslt1.1 libxslt1-dev

COPY ./ /var/www/

COPY ./config/docker/databases.yml /var/www/config
COPY ./config/docker/propel.ini /var/www/config

RUN docker-php-ext-install xsl
RUN docker-php-ext-install pdo_mysql

RUN curl --silent --show-error https://getcomposer.org/installer | php

COPY ./composer.json /var/www/
COPY ./composer.lock /var/www/

RUN php composer.phar install --no-plugins --no-scripts --no-interaction --ansi

RUN php symfony propel:build --all --no-confirmation
