FROM php:8.4-fpm-alpine

RUN apk add --no-cache fcgi \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY app.ini /usr/local/etc/php/conf.d/app.ini
COPY health.conf /usr/local/etc/php-fpm.d/zz-health.conf
USER www-data
WORKDIR /var/www/html
EXPOSE 9000
