FROM php:7.2-apache

MAINTAINER Carlos Martinez

RUN apt-get update && apt-get install -y zip git wget

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /srv/app \
    && a2enmod rewrite