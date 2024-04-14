FROM php:8.2-fpm

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    curl  \
    gnupg \
    symfony-cli \
    && docker-php-ext-install zip pdo pdo_mysql

RUN echo "assert.warning = 0" > /usr/local/etc/php/conf.d/php.ini
COPY php/php.ini /usr/local/etc/php/conf.d/php.ini
# Install Composer
#COPY --from=symfony-cli-installer /usr/bin/symfony /usr/bin/symfony
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
