<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\UserModel;
use App\Core\Database;
use App\Helpers\Flash;

class LoginController extends Controller
{

	public function index()
	{
		if (isset($_SESSION['user']))
		{
			header('Location: ' . BASE_URL);
			exit ;
		}

		$flash = Flash::get();

		$title = "Login - Camagraou";
		$desc = "Login - Camagraou";

		View::render('login', compact('title', 'desc', 'flash'));
	}

	private function error($error)
	{
		Flash::set('error', $error);
		header('Location: ' . BASE_URL . 'login');
		exit ;
	}

	public function login()
	{
		if (isset($_SESSION['user']))
		{
			header('Location: ' . BASE_URL);
			exit ;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$pseudo = trim($_POST['pseudo'] ?? '');
			$password = $_POST['password'] ?? '';

			if (empty($pseudo) || empty($password))
				$this->error("pseudo and password required !");

			$userModel = new UserModel(Database::getInstance());
			$user = $userModel->findByPseudo($pseudo);

			if ($user && password_verify($password, $user['password']))
			{
				$_SESSION['user'] = [
					'id' => $user['id'],
					'email' => $user['email'],
					'pseudo' => $user['pseudo'],
					'is_active' => $user['is_active'],
					'mail_notif' => $user['mail_notif']
				];
				header('Location: ' . BASE_URL);
				exit;
			}
			else
				$this->error("Login Incorrect.");
		}
	}
}
