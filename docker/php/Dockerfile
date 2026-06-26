FROM debian:11

RUN apt update && apt upgrade -y && \
	apt install -y php7.4-fpm php7.4-mysql \
	iproute2 bash curl php-gd ssmtp

RUN mkdir -p /run/php
COPY /conf/www.conf /etc/php/7.4/fpm/pool.d/www.conf
COPY /tool/script.sh /tmp/script.sh

COPY /conf/ssmtp.conf /etc/ssmtp/ssmtp.conf
# COPY /conf/mail.ini /usr/local/etc/php/conf.d/mail.ini
COPY /conf/mail.ini /etc/php/7.4/fpm/conf.d/mail.ini
# RUN echo 'sendmail_path = "/usr/sbin/ssmtp -t -i"' > /usr/local/etc/php/conf.d/mail.ini
# COPY /conf/php.ini /usr/local/etc/php/php.ini

RUN chmod +x /tmp/script.sh

ENTRYPOINT ["/tmp/script.sh"]
