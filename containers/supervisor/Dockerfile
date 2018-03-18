FROM php:7.1-fpm

RUN mkdir -p /var/log/supervisor/
WORKDIR /var/www/

RUN apt-get update && \
apt-get install -y --no-install-recommends supervisor

RUN touch /var/run/supervisor.sock && \
chmod 777 /var/run/supervisor.sock

COPY --from=videoserver_php /var/www/ /var/www/
COPY supervisord.conf /etc/supervisor/conf.d

RUN /etc/init.d/supervisor restart
