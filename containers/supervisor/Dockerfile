FROM php:7.1-fpm

WORKDIR /var/www/

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && \
apt-get install -y --no-install-recommends supervisor

COPY --from=videoserver_php /var/www/ /var/www/
COPY supervisord.conf /etc/supervisor/conf.d

RUN rm -rf /var/www/cache /var/www/logs

CMD supervisord -c /etc/supervisor/conf.d/supervisord.conf
