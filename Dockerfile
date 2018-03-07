FROM summittech/phalcon:7

#ENV PHPREDIS_VERSION 3.0.0
#ENV PHPIREDIS_VERSION 1.0.0

COPY composer.json /var/www/html/

RUN composer install

# Enabling mongo module
RUN apt-get update && apt-get -y install libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Installing PHPUnit
ADD https://phar.phpunit.de/phpunit-6.4.phar /var/www/html/
RUN chmod +x /var/www/html/phpunit-6.4.phar \
    && mv /var/www/html/phpunit-6.4.phar /usr/local/bin/phpunit

# Installing xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html/public", ".htrouter.php"]