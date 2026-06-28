FROM php:8.2-fpm

# RUN apt update && apt upgrade -y && \
# 	apt install -y php7.4-fpm php7.4-mysql \
# 	iproute2 bash curl php-gd ssmtp

RUN apt-get update && apt-get install -y \
		iproute2 bash curl \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		msmtp \
		msmtp-mta \
		ca-certificates \
	&& rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd pdo_mysql


COPY /conf/msmtprc /etc/msmtprc

RUN chmod 600 /etc/msmtprc \
 && chown www-data:www-data /etc/msmtprc

RUN echo 'sendmail_path = "/usr/bin/msmtp -t"' > \
    /usr/local/etc/php/conf.d/mail.ini

RUN mkdir -p /run/php
COPY /conf/www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY /tool/script.sh /tmp/script.sh

# COPY /conf/ssmtp.conf /etc/ssmtp/ssmtp.conf
# COPY /conf/mail.ini /usr/local/etc/php/conf.d/mail.ini
# COPY /conf/mail.ini /etc/php/8.2/fpm/conf.d/mail.ini
# RUN echo 'sendmail_path = "/usr/sbin/ssmtp -t -i"' > /usr/local/etc/php/conf.d/mail.ini
# COPY /conf/php.ini /usr/local/etc/php/php.ini

RUN chmod +x /tmp/script.sh

ENTRYPOINT ["/tmp/script.sh"]
