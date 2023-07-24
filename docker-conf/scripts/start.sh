#!/bin/bash

cd /var/www

php artisan key:generate
php artisan migrate:fresh

service nginx start

/usr/bin/supervisord
php artisan schedule:work > /dev/null 2>&1 &
exec php-fpm -F

