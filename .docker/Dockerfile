FROM php:8.2-apache

WORKDIR /app

COPY ./apache/docker.local.conf /etc/apache2/sites-available/docker.local.conf
COPY ./apache/ssl/docker.local-ssl.conf /etc/apache2/sites-available/docker.local-ssl.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu\
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
    # default-mysql-client \
#     default-mysql-server \
#     curl
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "chani@test.com" \ 
    && git config --global user.name "chani"

# RUN docker-php-ext-install mysqli pdo pdo_mysql zip unzip && docker-php-ext-enable mysqli pdo_mysql zip unzip
RUN a2ensite docker.local \
    #active la reecriture d'url sans index.php
    && a2enmod rewrite \
    && a2enmod ssl\
    && a2ensite docker.local-ssl




