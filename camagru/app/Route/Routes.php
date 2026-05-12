<?php

use App\Route\Router;

$router = new Router();

$router->registerMiddleware('auth', function() {
	if (!isset($_SESSION['user']))
	{
		header('Location: /public/login');
		return (false);
	}
	return (true);
});

$router->registerMiddleware('admin', function() {
	if (!isset($_SESSION['user']) || $_SESSION['user']['roler'] !== 'admin')
	{
		http_response_code(403);
		echo "Admin only, sorry...";
		return (false);
	}
	return (true);
});

// routes
$router->get('', 'HomeController@index');

$router->dispatch();
