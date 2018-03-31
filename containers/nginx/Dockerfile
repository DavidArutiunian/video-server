FROM nginx:latest

WORKDIR /var/www/

COPY --from=videoserver_php /var/www/ /var/www/
COPY default.conf /etc/nginx/conf.d

RUN chmod -R 777 /var/www/web/uploads && \
 rm -rf /var/www/cache /var/www/logs
