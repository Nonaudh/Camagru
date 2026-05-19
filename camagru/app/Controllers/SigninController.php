<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Controller;
use App\Core\View;
use App\Core\Database;

class SigninController extends Controller
{
	public function index()
	{
		if (isset($_SESSION['user']))
			exit;

		$title = "Signin - Camagraou";
		$desc = "Signin - Camagraou";

		View::render('signin', compact('title', 'desc'));
	}

	public function register()
	{
		if (isset($_SESSION['user']))
			exit;

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$errors = [];
			$pseudo = trim($_POST['pseudo'] ?? '');
			$email = trim($_POST['email'] ?? '');
			$password = $_POST['password'] ?? '';
			$confim = $_POST['confirm_password'] ?? '';
			
			if (empty($pseudo))
				$errors['pseudo'] = "Pseudo is needed.";
			elseif (strlen($pseudo) < 4)
				$errors['pseudo'] = "Pseudo need to have at least 4 caracters.";

			if (empty($email))
				$errors['email'] = "Email is needed.";
			elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
				$errors['email'] = "Invalid Email.";

			if (empty($password))
				$errors['password'] = "Password is needed.";
			elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password))
				$errors['password'] = "Password need to have at least 8 caracters, an uppercase letter and a number.";
			
			if ($password !== $confim)
				$errors['confirm'] = "Passwords does not matches.";

			if (!empty($errors))
			{
				$_SESSION['errors'] = $errors;
				$_SESSION['old'] = $_POST;

				header('Location: '.BASE_URL.'signin');
				exit;
			}

			$userModel = new UserModel(Database::getInstance());

			$existCheck = $userModel->checkExistingEmailAndPseudo(strtolower($email), $pseudo);

			if ($existCheck['email'] || $existCheck['pseudo'])
			{
				if ($existCheck['email'])
					$errors['email'] = 'Email already exist.';
				if ($existCheck['pseudo'])
					$errors['pseudo'] = 'Pseudo already exist.';

				$_SESSION['errors'] = $errors;
				$_SESSION['old'] = $_POST;

				header('Location: '.BASE_URL.'signin');
				exit;
			}
			$hachedPassword = password_hash($password, PASSWORD_DEFAULT);

			$userModel->create([
				'email' => $email,
				'password' => $hachedPassword,
				'pseudo' => $pseudo
				// add other
			]);

			$_SESSION['user'] = [
				'pseudo' => $pseudo,
				'email' => $email,
				'role' => 'user'
			];

			header('Location: '.BASE_URL);
			exit;
		}
	}
}
