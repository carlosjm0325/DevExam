#!/bin/sh

cd /srv/app  
composer update
php artisan migrate:fresh --seed --force

# execute apache
exec "apache2-foreground"
