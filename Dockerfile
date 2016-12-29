FROM richarvey/nginx-php-fpm:php7
MAINTAINER Mihhac <finder_ausberlin@yahoo.de> version 0.1

RUN cp /usr/bin/php7 /usr/bin/php
RUN apk update
RUN apk add php7-bcmath
RUN apk add php7-xdebug
RUN echo "zend_extension=xdebug.so" >> /etc/php7/conf.d/xdebug.ini

ADD . /var/www/html

WORKDIR /var/www/html
