#!/bin/bash

cd /var/www

php artisan key:generate
php artisan migrate
service nginx start
exec php-fpm -F




