FROM php:7.4-apache

RUN echo 'date.timezone = "Asia/Tokyo"' > /usr/local/etc/php/conf.d/timezone.ini
RUN echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/mhsendmail.ini
RUN a2enmod rewrite

RUN apt-get update && \
    apt-get install -y libmcrypt-dev libonig-dev openssl zip unzip

RUN docker-php-ext-install pdo_mysql mysqli

RUN pecl install mcrypt-1.0.3 && docker-php-ext-enable mcrypt

RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

EXPOSE 80
