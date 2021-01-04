#!/bin/sh

cd /srv/app  
composer update
php artisan migrate:fresh --seed --force
php artisan key:generate

# execute apache
/usr/sbin/apache2ctl -D FOREGROUND;
