<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Controller;
use App\Core\View;
use App\Core\Database;
use App\Helpers\Flash;

class SigninController extends Controller
{
	public function index()
	{
		if (isset($_SESSION['user']))
			header('Location: ' . BASE_URL);

		$title = "Signin - Camagraou";
		$desc = "Signin - Camagraou";

		$flash = Flash::get();

		View::render('signin', compact('title', 'desc', 'flash'));
	}

	private function flash_and_quit($type, $message, $path)
	{
		Flash::set($type, $message);
		header('Location: ' . BASE_URL . $path);
		exit ;
	}

	public function register()
	{
		if (isset($_SESSION['user']))
			exit;

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$pseudo = trim($_POST['pseudo'] ?? '');
			$email = trim($_POST['email'] ?? '');
			$password = $_POST['password'] ?? '';
			$confim = $_POST['confirm_password'] ?? '';

			$_SESSION['old'] = $_POST;
			
			if (empty($pseudo))
				$this->flash_and_quit("error", "Pseudo is needed.", "signin");
			if (strlen($pseudo) < 4)
				$this->flash_and_quit("error", "Pseudo need to have at least 4 caracters.", "signin");

			if (empty($email))
				$this->flash_and_quit("error", "Email is needed.", "signin");
			elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
				$this->flash_and_quit("error", "Invalid Email.", "signin");

			if (empty($password))
				$this->flash_and_quit("error", "Password is needed.", "signin");
			elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password))
				$this->flash_and_quit("error", "Password need to have at least 8 caracters, an uppercase letter and a number.", "signin");
			
			if ($password !== $confim)
				$this->flash_and_quit("error", "Passwords does not matches.", "signin");

			$userModel = new UserModel(Database::getInstance());

			$existCheck = $userModel->checkExistingEmailAndPseudo(strtolower($email), $pseudo);

			if ($existCheck['pseudo'])
				$this->flash_and_quit("error", "Pseudo already exist.", "signin");
			if ($existCheck['email'])
				$this->flash_and_quit("error", "Email already exist.", "signin");

			$hachedPassword = password_hash($password, PASSWORD_DEFAULT);

			$verification_token = bin2hex(random_bytes(32));
			$token_expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

			$data = $userModel->create([
				'email' => $email,
				'password' => $hachedPassword,
				'pseudo' => $pseudo,
				'is_active' => 0,
				'verification_token' => $verification_token,
				'reset_token_expiry' => $token_expiry
			]);

			$_SESSION['user'] = [
				'id' => $data['id'],
				'pseudo' => $pseudo,
				'email' => $email,
				'role' => 'user',
				'is_active' => 0
			];

			if (DEVELOPMENT == true)
				$this->flash_and_quit("success", "https://localhost:8443/verify?token=" . $verification_token, '');
			$this->flash_and_quit("success", "Account successfully created !", '');
		}
	}
}
