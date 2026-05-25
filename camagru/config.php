<?php

define('DB_HOST', getenv('MARIADB_USER_HOST'));
define('DB_NAME', getenv('MARIADB_DATABASE'));
define('DB_USER', getenv('MARIADB_USER'));
define('DB_PASS', getenv('MARIADB_PASSWORD'));

define('BASE_URL', '/');
define('DEVELOPMENT', true);
