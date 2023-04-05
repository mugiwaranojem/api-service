ARG NGINX_VERSION=1.15
ARG PHP_VERSION=8.1

#------------------------------------------------------------------
# Nginx build
#------------------------------------------------------------------
FROM nginx:${NGINX_VERSION}-alpine AS api_project-nginx
WORKDIR "/usr/share/nginx/html"
RUN apk update && apk add bash

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/init.sh /init.sh

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
ENTRYPOINT ["sh", "/init.sh"]

RUN ln -sf /dev/stdout /var/log/nginx/access.log && ln -sf /dev/stderr /var/log/nginx/error.log

#------------------------------------------------------------------
# PHP build
#------------------------------------------------------------------
FROM php:${PHP_VERSION}-fpm-alpine AS api_project-php

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

WORKDIR /var/www/

# Copy existing application directory contents
COPY vms-comics-api/ /var/www
RUN ls -la /var/www/

ENV APP_KEY="AndEnbtvRU573dVEUqq5X8erpXYfGhFm"
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install --no-dev --no-progress --no-interaction
RUN composer dump-autoload --no-dev

RUN php artisan config:cache && \
    php artisan route:cache && \
    chown -R www-data:www-data /var/www/ && \
    chmod 755 -R /var/www/storage/

COPY docker/php/init.sh /init.sh

# Expose port 9000 and start php-fpm server
EXPOSE 9000

ENTRYPOINT ["sh", "/init.sh"]
CMD ["php-fpm"]
