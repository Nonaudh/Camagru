FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
		iproute2 bash curl \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		ca-certificates \
	&& rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd pdo_mysql

RUN curl -fsSL https://github.com/mailhog/mhsendmail/releases/latest/download/mhsendmail_linux_amd64 \
    -o /usr/local/bin/mhsendmail \
 && chmod +x /usr/local/bin/mhsendmail

# COPY /conf/www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY /conf/mail.ini /usr/local/etc/php/conf.d/mail.ini

COPY /tool/script.sh /tmp/script.sh
RUN chmod +x /tmp/script.sh

ENTRYPOINT ["/tmp/script.sh"]
