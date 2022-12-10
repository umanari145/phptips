FROM php:8.0-apache

RUN echo 'date.timezone = "Asia/Tokyo"' > /usr/local/etc/php/conf.d/timezone.ini
RUN echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/mhsendmail.ini
RUN a2enmod rewrite

RUN apt-get update && \
    apt-get install -y libmcrypt-dev libonig-dev openssl zip unzip

RUN docker-php-ext-install pdo_mysql mysqli

RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN apt-get install -y libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev zlib1g-dev libzip-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg 
RUN docker-php-ext-install -j$(nproc) gd 
RUN docker-php-ext-install zip

EXPOSE 80
