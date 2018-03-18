FROM nginx:latest

WORKDIR /var/www/

COPY --from=videoserver_php /var/www/ /var/www/
COPY default.conf /etc/nginx/conf.d
