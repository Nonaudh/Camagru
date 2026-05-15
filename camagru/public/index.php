<?php

session_start();

echo("URI " . $_SERVER['REQUEST_URI']);

require_once __DIR__ . '/../config.php';

if (DEVELOPMENT == true)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../app/Route/Routes.php';
