FROM nginx:1.17

RUN rm /etc/nginx/conf.d/default.conf
COPY vhost.conf /etc/nginx/conf.d/vhost.conf

WORKDIR /var/www/
