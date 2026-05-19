FROM debian:11

RUN apt update && apt upgrade -y && \
	apt install -y php7.4-fpm php7.4-mysql \
	iproute2 bash curl

RUN mkdir -p /run/php
COPY /conf/www.conf /etc/php/7.4/fpm/pool.d/www.conf

CMD ["php-fpm7.4", "-F"]
