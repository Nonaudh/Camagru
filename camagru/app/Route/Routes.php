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
$router->post('/login/post', 'LoginController@login');

$router->get('/logout', 'LogoutController@index');

$router->get('/webcam', 'WebcamController@index')->middleware('auth');

$router->get('/error404', 'ErrorController@notFound');

$router->get('/forgot', 'AuthController@forgotForm');
$router->post('/forgot', 'AuthController@handleForgot');

$router->dispatch();
