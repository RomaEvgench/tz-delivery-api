#!/bin/bash

cd /var/www

php artisan key:generate
php artisan migrate:fresh
service nginx start
exec php-fpm -F




