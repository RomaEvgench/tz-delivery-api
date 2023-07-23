#!/bin/bash

cd /var/www

php artisan key:generate
php artisan migrate:fresh

service nginx start

/usr/bin/supervisord

exec php-fpm -F
