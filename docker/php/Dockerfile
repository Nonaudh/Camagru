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

RUN mkdir -p /run/php
COPY /conf/www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY /tool/script.sh /tmp/script.sh

# COPY /conf/ssmtp.conf /etc/ssmtp/ssmtp.conf
COPY /conf/mail.ini /usr/local/etc/php/conf.d/mail.ini
# COPY conf/mail.ini /etc/php/8.2/fpm/conf.d/mail.ini
# RUN echo 'sendmail_path = "/usr/sbin/ssmtp -t -i"' > /usr/local/etc/php/conf.d/mail.ini
# COPY /conf/php.ini /usr/local/etc/php/php.ini

RUN chmod +x /tmp/script.sh

ENTRYPOINT ["/tmp/script.sh"]
