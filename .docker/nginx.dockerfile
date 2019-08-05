FROM nginx:alpine

ADD .docker/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www
COPY . /var/www
RUN chmod -Rf 777 /var/www/storage/
