FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx \
    && docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/

RUN echo 'server {
    listen 80;
    root /var/www/html/public;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}' > /etc/nginx/http.d/default.conf

EXPOSE 80

CMD php-fpm -D && nginx -g "daemon off;"