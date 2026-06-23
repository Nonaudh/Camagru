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
	if ($_SESSION['user']['is_active'] == 0)
	{
		Flash::set('error', 'You must activate your account to access this page');
		header('Location: /');
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
$router->get('/gallery', 'HomeController@getPictures');

$router->get('/signin', 'SigninController@index');
$router->post('/register', 'SigninController@register');

$router->get('/login', 'LoginController@index');
$router->post('/login/post', 'LoginController@login');

$router->get('/profile', 'ProfileController@index');
$router->get('/profile/post', 'ProfileController@profile');

$router->get('/verify', 'VerifyController@index');

$router->get('/logout', 'LogoutController@index');

$router->get('/webcam', 'WebcamController@index')->middleware('auth');
$router->post('/webcam/fileInput', 'WebcamController@handleFileInput')->middleware('auth');
$router->post('/webcam/capture', 'WebcamController@capture')->middleware('auth');
$router->get('/thumbnails', 'WebcamController@getThumbnails')->middleware('auth');
$router->post('/deleteImage', 'WebcamController@deleteImage')->middleware('auth');

$router->get('/error404', 'ErrorController@notFound');

$router->get('/forgot', 'AuthController@forgotForm');
$router->post('/forgot', 'AuthController@handleForgot');
$router->get('/reset', 'AuthController@reset');
$router->post('/updatePassword', 'AuthController@updatePassword');

$router->get('/image', 'ImageController@index');

$router->post('/comment', 'CommentController@commentForm');

$router->post('/like', 'LikeController@likeImage');

$router->dispatch();
