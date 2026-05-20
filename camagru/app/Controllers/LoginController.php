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

		$_SESSION['login_error'] = '';

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$email = trim($_POST['email'] ?? '');
			$password = trim($_POST['password'] ?? '');

			if (empty($email) || empty($password))
				$this->error("email and password required !");

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				$this->error("Invalid e-mail address.");

			$userModel = new UserModel(Database::getInstance());
			$user = $userModel->findByEmail($email);

			if ($user && password_verify($password, $user['password']))
			{
				$_SESSION['user'] = [
					'id' => $user['id'],
					'email' => $user['email'],
					'pseudo' => $user['pseudo']
				];
				header('Location: ' . BASE_URL);
				exit;
			}
			else
				$this->error("Login Incorrect.");
		}
	}
}
