<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\User;
use App\Core\Database;

class LoginController extends Controller
{
	public function index()
	{
		if (isset($_SESSION['user']))
		{
			header('Location :' . BASE_URL);
			exit ;
		}

		$title = "Login - Camagraou";
		$desc = "Login - Camagraou";

		$errors = $_SESSION['login_errors'] ?? [];
		unset($_SESSION['login_errors']);

		View::render('login', compact('title', 'desc', 'errors'));
	}

	public function login()
	{
		if (isset($_SESSION['user']))
		{
			header('Location :' . BASE_URL);
			exit ;
		}

		$errors = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$email = trim($_POST['email'] ?? '');
			$password = trim($_POST['password'] ?? '');

			if (empty($email) || empty($password))
				$errors[] = "email and password required.";

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				$errors[] = "Invalid e-mail address.";

			if (empty($errors))
			{
				$userModel = new User(Database::getInstance());
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
					$errors[] = "Login Incorrect.";
			}
		}
		if (!empty($errors))
		{
			$_SESSION['login-errors'] = $errors;
			header('Location: ' . BASE_URL . 'login');
			exit;
		}
	}
}
