FROM        php:8.0-fpm-alpine
MAINTAINER  Arnaud Ponel <arnaud@xpressive.io>

RUN         apk add --no-cache \
            --repository http://dl-cdn.alpinelinux.org/alpine/edge/main \
            --repository  http://dl-cdn.alpinelinux.org/alpine/edge/community \
            freetype-dev icu-dev libjpeg-turbo-dev libpng-dev libwebp-dev libzip-dev shadow zlib-dev

RUN         usermod -u 1000 www-data && \
            groupmod -g 1000 www-data

RUN         mkdir -p /app
COPY        --chown=www-data:www-data . /app

RUN         mkdir -p /build
COPY        ./docker/services/app /build

COPY        ./docker/services/app/conf.d /usr/local/etc/php/conf.d

#RUN         docker-php-ext-configure gd \
#            --with-freetype-dir=/usr/include/ \
#            --with-jpeg-dir=/usr/include/ \
#            --with-webp-dir=/usr/include/
RUN         docker-php-ext-install pdo_mysql zip #gd
#ENV         PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"
#RUN         docker-php-ext-configure intl --enable-intl && \
#            docker-php-ext-install intl

ENV         COMPOSER_MEMORY_LIMIT=-1
ENV         COMPOSER_HOME=/var/lib/composer
RUN         mkdir -p $COMPOSER_HOME
RUN         chown -R www-data:www-data $COMPOSER_HOME
RUN         cd /tmp && /build/install_composer.sh

VOLUME      /app
WORKDIR     /app

ENV         APP_ENV=dev

ENTRYPOINT  ["/build/entrypoint.sh"]
CMD         ["php-fpm"]
