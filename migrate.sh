#!/bin/sh

cd /srv/app  
composer update
php artisan migrate:fresh --seed --force

# execute apache
/usr/sbin/apache2ctl -D FOREGROUND;
