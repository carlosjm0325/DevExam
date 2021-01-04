#!/bin/sh

cd /srv/app  
composer update
php artisan migrate:fresh --seed --force
php artisan key:generate
chmod 777 -R storage
chmod 777 -R bootstrap/cache
cp env.example .env

# execute apache
/usr/sbin/apache2ctl -D FOREGROUND;
