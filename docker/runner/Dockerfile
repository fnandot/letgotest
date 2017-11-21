FROM debian:jessie

MAINTAINER Fernando Pradas <fnando08@gmail.com>

ARG COMPOSER_VERSION=1.5.2
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update --force-yes \
    && apt-get install -qq -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" \
        wget \
        curl \
        git \
        zip \
        apt-transport-https \
        ca-certificates \
        openssl

ADD rootfs /

RUN wget -O /tmp/php.gpg https://packages.sury.org/php/apt.gpg \
    && apt-key add /tmp/php.gpg \
    && apt-get update \
    && apt-get install -y \
        php7.1 \
        php7.1-curl \
        php7.1-cli \
        php7.1-xml \
        php7.1-mbstring \
        php7.1-xdebug \
    && rm -rf /var/lib/apt/lists/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} \
    && php -r "unlink('composer-setup.php');" \
    && composer global require "hirak/prestissimo:^0.3.7"

WORKDIR "/app"

