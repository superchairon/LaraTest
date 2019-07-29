FROM php:7.1-fpm

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN apt-get update && apt-get install -y \
        libpq-dev libgd-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Optionally install: calendar exif gettext intl pcntl pgsql shmop sockets sysvmsg sysvsem sysvshm wddx xsl Zend OPcache zip

