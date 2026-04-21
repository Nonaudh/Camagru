FROM debian:11

RUN apt update && apt upgrade -y
RUN apt install -y php7.4-fpm php7.4-mysql curl
RUN apt install -y iproute2

RUN mkdir -p /run/php
COPY /conf/www.conf /etc/php/7.4/fpm/pool.d/.

#COPY tools/script.sh tmp/.
#RUN chmod +x tmp/script.sh
#COPY index.php /var/www/html/.

#ENTRYPOINT ["tmp/script.sh"]
CMD ["php-fpm7.4", "-F"]
