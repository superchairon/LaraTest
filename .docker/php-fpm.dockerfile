FROM superchairon/laratest_php-fpm-base:latest

WORKDIR /var/www
COPY . /var/www
RUN chmod -Rf 777 /var/www/storage/
