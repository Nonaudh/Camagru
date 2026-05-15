<?php

use App\Route\Router;

$router = new Router();

$router->registerMiddleware('auth', function() {
	if (!isset($_SESSION['user']))
	{
		header('Location: /login');
		return (false);
	}
	return (true);
});

$router->registerMiddleware('admin', function() {
	if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin')
	{
		http_response_code(403);
		header('Location: /');
		return (false);
	}
	return (true);
});

// routes
$router->get('', 'HomeController@index');

$router->get('/signin', 'SigninController@index');
$router->post('/register', 'SigninController@register');
$router->get('/login', 'LoginController@index');
$router->get('/logout', 'LogoutController@index');

$router->get('/webcam', 'WebcamController@index')->middleware('auth');

$router->dispatch();
