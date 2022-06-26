FROM php:8.1-fpm-alpine3.16

RUN apk add bash \
    && apk add autoconf \
    && apk add make \
    && apk add g++ \
    && apk add php-pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
    && php composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer

RUN apk add --update nodejs npm \
    && npm install --global yarn

COPY dev/docker/php-fpm/symfony.ini /etc/php/conf.d/
COPY dev/docker/php-fpm/symfony.ini /etc/php/cli/conf.d/

COPY dev/docker/php-fpm/symfony.pool.conf /etc/php/php-fpm.d/

# Configure Xdebug
#RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \

WORKDIR /var/www/symfony

CMD ["php-fpm", "-F"]

EXPOSE 9001
