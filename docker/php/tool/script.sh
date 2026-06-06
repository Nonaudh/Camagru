#!/bin/sh

chown www-data:www-data /var/www/html/public/images
chmod 755 /var/www/html/public/images

exec php-fpm7.4 -F
