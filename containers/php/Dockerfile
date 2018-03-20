FROM php:7.1-fpm AS videoserver_php

WORKDIR /var/www/

RUN apt-get update && \
apt-get install -y --no-install-recommends git zip unzip libxslt1.1 libxslt1-dev

COPY ./ /var/www/

RUN mkdir -p /var/www/web/uploads
RUN chmod -R 777 /var/www/web/uploads

RUN docker-php-ext-install xsl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets

RUN curl --silent --show-error https://getcomposer.org/installer | php

RUN COMPOSER_ALLOW_SUPERUSER=1 php composer.phar install --no-plugins --no-scripts --no-interaction --ansi

COPY ./config/docker/databases.yml /var/www/config
COPY ./config/docker/propel.ini /var/www/config
COPY ./config/docker/rabbitmq.yml /var/www/config

RUN php symfony propel:build --model && \
php symfony propel:build --forms && \
php symfony propel:build --filters && \
php symfony propel:build --sql

CMD php symfony propel:insert-sql --no-confirmation && php-fpm
