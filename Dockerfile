FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install pdo pdo_mysql \
    && rm /etc/apache2/mods-enabled/mpm_event.conf \
    && rm /etc/apache2/mods-enabled/mpm_event.load \
    && ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load

EXPOSE 80