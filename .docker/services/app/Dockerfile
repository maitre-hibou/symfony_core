FROM        php:8.1
LABEL       maintainer="Arnaud P <arnaud@xpressive.io>"

ENV         APP_ENV=dev
ENV         COMPOSER_HOME=/usr/local/lib/composer

RUN         echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN         apt update && \
            apt install -y curl libcurl4-openssl-dev libicu-dev librabbitmq-dev libxml2-dev libzip-dev symfony-cli unzip wget zip

RUN         usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN         mkdir -p /build
COPY        .docker/services/app /build

COPY        .docker/services/app/conf.d /usr/local/etc/php/conf.d

RUN         pecl install amqp apcu
RUN         docker-php-ext-install bcmath ctype curl intl opcache pdo_mysql simplexml zip
RUN         docker-php-ext-enable amqp apcu opcache

RUN         mkdir -p $COMPOSER_HOME
RUN         chown -R www-data:www-data $COMPOSER_HOME
WORKDIR     /tmp
RUN         /build/install_composer.sh

RUN         mkdir -p /app
COPY        --chown=www-data:www-data . /app

EXPOSE      8000
VOLUME      /app
WORKDIR     /app

ENTRYPOINT  ["/build/entrypoint.sh"]
CMD         ["symfony", "serve", "--port=8000"]
