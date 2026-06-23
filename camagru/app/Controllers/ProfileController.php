<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Controller;
use App\Core\View;
use App\Core\Database;
use App\Helpers\Flash;

class ProfileController extends Controller
{
	public function index()
	{
		if (!isset($_SESSION['user']) || !$_SESSION['user']['is_active'])
			header('Location: ' . BASE_URL);

		$title = "Profile - Camagraou";
		$desc = "Profile - Camagraou";

		$flash = Flash::get();

		View::render('profile', compact('title', 'desc', 'flash'));
	}

	private function flash_and_quit($type, $message, $path)
	{
		Flash::set($type, $message);
		header('Location: ' . BASE_URL . $path);
		exit ;
	}

	public function profile()
	{
		
	}
}