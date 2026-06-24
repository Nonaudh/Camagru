<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Controller;
use App\Core\View;
use App\Core\Database;
use App\Helpers\Flash;

class VerifyController extends Controller
{
	private function flash_and_quit($type, $message, $path)
	{
		Flash::set($type, $message);
		header('Location: ' . BASE_URL . $path);
		exit ;
	}

    public function index()
    {
		// if (isset($_SESSION['user']) && $_SESSION['user']['is_active'] == 1)
		// {
		// 	header('Location: ' . BASE_URL);
		// 	exit ;
		// }

		if (!isset($_GET['token']) || empty($_GET['token']))
			$this->flash_and_quit('error', 'Invalid verification link', '');

		$token = htmlspecialchars($_GET['token']);

		$userModel = new UserModel(Database::getInstance());

		$user = $userModel->findByTokenVerify($token);

		if (!$user || $user['is_active'] == 1 || strtotime($user['reset_token_expiry']) < time())
			$this->flash_and_quit('error', 'Verification link is invalid or expired', '');

		$userModel->activateAccount($user['id']);

		$_SESSION['user']['is_active'] = 1;

		$this->flash_and_quit('success', 'Account successfully activate !', '');
	}
}
