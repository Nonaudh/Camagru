<?php

require_once __DIR__ . '/../autoload.php';

use App\Controllers\HomeController;

if (class_exists(HomeController::class))
{
	$controller = new HomeController();

	if (method_exists($controller, 'index'))
		$controller->index();
	else
		require_once __DIR__ . '/../app/Views/error.php';
}
else
	require_once __DIR__ . '/../app/Views/error.php';

