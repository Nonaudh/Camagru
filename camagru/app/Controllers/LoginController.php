<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class LoginController extends Controller
{
	public function index()
	{
		if (isset($_SESSION['user']))
			exit ;

		$title = "Login - Camagraou";
		$desc = "Login - Camagraou";

		View::render('login', compact('title', 'desc'));
	}
}
