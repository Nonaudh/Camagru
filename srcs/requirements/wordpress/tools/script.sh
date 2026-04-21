#!/bin/bash

if [ ! -f /var/www/html/wp-config.php ]; then

	cd /var/www/html
	curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
	chmod +x wp-cli.phar
	./wp-cli.phar core download --allow-root
	./wp-cli.phar config create --dbname=${DB_NAME} --dbuser=${DB_USER} --dbpass=${DB_PASS} --dbhost=${DB_HOST} --allow-root
	./wp-cli.phar core install --url=${URL} --title=inception --admin_user=${WP_ADMIN_USER} --admin_password=${WP_ADMIN_PASS} --admin_email=${WP_ADMIN_EMAIL} --allow-root
	./wp-cli.phar user create ${USER} ${USER}@42.com --role=subscriber --user_pass=${WP_USER_PASS} --allow-root
fi

php-fpm7.4 -F