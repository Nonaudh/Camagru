<?php

use App\Route\Router;
use App\Helpers\Flash;

$router = new Router();

$router->registerMiddleware('auth', function() {
	if (!isset($_SESSION['user']))
	{
		Flash::set('error', 'You must be logged in to access this page');
		header('Location: /login');
		return (false);
	}
	return (true);
});

$router->registerMiddleware('admin', function() {
	if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin')
	{
		Flash::set('error', 'Forbidden, sorry...');
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
$router->post('/webcam/fileInput', 'WebcamController@handleFileInput');
$router->post('/webcam/capture', 'WebcamController@capture'); 

$router->get('/error404', 'ErrorController@notFound');

$router->get('/forgot', 'AuthController@forgotForm');
$router->post('/forgot', 'AuthController@handleForgot');
$router->get('/reset', 'AuthController@reset');
$router->post('/updatePassword', 'AuthController@updatePassword');

$router->dispatch();
