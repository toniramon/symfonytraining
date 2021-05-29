FROM php:7.4-apache
LABEL maintainer="Toni Ramon <info@toniramon.es>"
LABEL description="Official image of PHP"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y \
    nano \
    libbz2-dev \
    mariadb-client \
    libgmp-dev \
    git \
    zip \
    supervisor \
    ssh \
    unzip \
    libpng-dev \
    wait-for-it \
    iputils-ping \
    libicu-dev \
    libpq-dev 

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bz2
RUN docker-php-ext-install gd
RUN docker-php-ext-install gmp
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo pgsql pdo_pgsql 

RUN set -eux; apt-get update; apt-get install -y libzip-dev zlib1g-dev; docker-php-ext-install zip
RUN pecl install xdebug-2.9.5
RUN docker-php-ext-enable xdebug
RUN a2enmod rewrite

#configure apache
ARG UID=501
ENV UID ${UID}

RUN useradd -u ${UID} -g www-data -m tonidev && \
    usermod -p "*" tonidev

ARG DOCUMENT_ROOT=/var/www/html
ENV APACHE_RUN_USER tonidev
ENV APACHE_RUN_GROUP www-data
ENV WEB_DOCUMENT_ROOT=${DOCUMENT_ROOT}

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#create a vhost file and assign public directory
COPY ./settings/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./settings/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./settings/supervisor-apache.conf /etc/supervisor/conf.d/supervisor-apache.conf
COPY ./settings/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# RUN mkdir /root/.ssh/
# ADD ./settings/ssh/id_rsa /root/.ssh/id_rsa
# RUN chmod 600 /root/.ssh/id_rsa
# RUN touch /root/.ssh/known_hosts
# RUN ssh-keyscan -T 60 bitbucket.org >> /root/.ssh/known_hosts

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    composer self-update --preview
RUN command -v composer

# Node.js
RUN curl -sL https://deb.nodesource.com/setup_12.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install nodejs -y
RUN npm install npm@6.9.0 -g
RUN command -v node
RUN command -v npm
