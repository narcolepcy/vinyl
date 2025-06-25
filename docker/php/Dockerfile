FROM php:7.4-apache
COPY ./php.ini /usr/local/etc/php/
COPY ./*.conf /etc/apache2/sites-enabled/

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    graphviz \
    unzip \
    && docker-php-ext-configure \
    gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install \
    gd \
    pdo_mysql \
    mysqli \
    zip \
    && a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

RUN composer global require "laravel/installer"
