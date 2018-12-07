FROM chaplean/php:7.1-no-xdebug
MAINTAINER Tom - Chaplean <tom@chaplean.coop>

ENV COMPOSER_HOME=${HOME}/cache/composer

# Workdir
VOLUME /var/www/symfony
WORKDIR /var/www/symfony/
