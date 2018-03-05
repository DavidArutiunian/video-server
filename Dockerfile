FROM php:7.1-fpm

RUN mkdir -p /var/www/
WORKDIR /var/www/

RUN apt-get update && apt-get install -y --no-install-recommends git zip unzip

RUN curl --silent --show-error https://getcomposer.org/installer | php

COPY composer.json /var/www/
COPY composer.lock /var/www/
RUN php composer.phar install --no-plugins --no-scripts --no-interaction --ansi

COPY . /var/www/

RUN rm -rf cache logs

RUN php symfony propel:build --all --and-load --no-confirmation
