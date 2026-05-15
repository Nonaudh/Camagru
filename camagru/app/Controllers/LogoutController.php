<?php

namespace App\Controllers;

class LogoutController
{
	public function index()
	{
		session_unset();
		session_destroy();
		header('Location: '.BASE_URL.'login');
		exit;
	}
}
