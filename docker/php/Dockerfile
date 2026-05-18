FROM debian:11

RUN apt update && apt upgrade -y
RUN apt install -y php7.4-fpm php7.4-mysql
RUN apt install -y iproute2 bash sendmail curl

RUN mkdir -p /run/php
COPY /conf/www.conf /etc/php/7.4/fpm/pool.d/www.conf

CMD ["php-fpm7.4", "-F"]
