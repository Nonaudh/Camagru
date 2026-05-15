#!/bin/bash

cat << EOF > /etc/mysql/init.sql
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`;
CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'%';
ALTER USER 'root'@'localhost' IDENTIFIED BY '${SQL_ROOT_PASSWORD}';
FLUSH PRIVILEGES;

USE \`${DB_NAME}\`;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL
);
EOF

mysql_install_db
mysqld

# service mysql start

# mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`;"
# mysql -e "CREATE USER IF NOT EXISTS \`${USER}\`@'%' IDENTIFIED BY '${WP_USER_PASS}';"
# mysql -e "GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO \`${USER}\`@'%';"
# mysql -e "ALTER USER 'root'@'%' IDENTIFIED BY '${SQL_ROOT_PASSWORD}';"
# mysql -e "FLUSH PRIVILEGES;"
# mysqladmin -u root -p ${SQL_ROOT_PASSWORD} shutdown

# exec mysqld_safe

# # Initialise le répertoire de données MariaDB
# mysql_install_db --user=mysql --datadir=/var/lib/mysql

# # Démarre MariaDB en mode bootstrap
# mariadbd --user=mysql --bootstrap <<EOF
# USE mysql;
# FLUSH PRIVILEGES;

# # Supprimez l'utilisateur et la base de données par défaut
# DROP USER IF EXISTS ''@'localhost';
# DROP DATABASE IF EXISTS test;

# # Créez la base de données WordPress et l'utilisateur
# CREATE DATABASE IF NOT EXISTS $SQL_DATABASE;
# CREATE USER IF NOT EXISTS '$SQL_USER'@'%' IDENTIFIED BY '$SQL_PASSWORD';
# GRANT ALL PRIVILEGES ON $SQL_DATABASE.* TO '$SQL_USER'@'%';

# # Changez le mot de passe de l'utilisateur root
# ALTER USER 'root'@'localhost' IDENTIFIED BY '$SQL_ROOT_PASSWORD';
# FLUSH PRIVILEGES;
# EOF

# # Exécute MariaDB
# exec mariadbd
