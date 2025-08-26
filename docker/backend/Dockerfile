FROM php:8.3-fpm

COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    zip \
    unzip \
    vim \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql

WORKDIR /usr/bin
RUN curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

WORKDIR /var/www
