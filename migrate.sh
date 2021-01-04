#!/bin/sh

cd /srv/app  
composer update
php artisan migrate:fresh --seed

# execute apache
exec "apache2-foreground"
