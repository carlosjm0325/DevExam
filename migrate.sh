#!/bin/sh

cd /srv/app  
composer update
php artisan migrate --seed --force

# execute apache
exec "apache2-foreground"
