FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install pdo pdo_mysql \
    && a2dismod mpm_event || true \
    && a2enmod mpm_prefork rewrite

EXPOSE 80