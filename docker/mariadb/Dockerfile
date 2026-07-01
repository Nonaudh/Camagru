FROM debian:13

RUN apt update && apt upgrade -y
RUN apt install -y mariadb-server bash

COPY conf/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf

COPY tools/script.sh /tmp/script.sh
RUN chmod +x /tmp/script.sh

RUN mkdir -p /run/mysqld /var/lib/mysql
RUN chown -R mysql:mysql /run/mysqld /var/lib/mysql

ENTRYPOINT ["/tmp/script.sh"]
