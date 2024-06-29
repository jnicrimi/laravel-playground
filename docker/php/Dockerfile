FROM php:8.3-fpm

COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim

RUN docker-php-ext-install pdo_mysql

RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

WORKDIR /var/www/html
