<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\UserModel;
use App\Core\Database;
use App\Helpers\Flash;

class AuthController extends Controller
{
	public function forgotForm()
	{
		$title = "Camagraou - Forgot Password ?";
		$desc = "Reset your password by entering your e-mail.";

		$flash = Flash::get();

		View::render("auth/forgot", compact('title', 'desc', 'flash'));
	}

	private function flash_and_quit($type, $message)
	{
		Flash::set($type, $message);
		header('Location: ' . BASE_URL . 'forgot');
		exit ;
	}

	public function handleForgot()
	{
		$title = "Camagraou - Forgot Password ?";

		$email = strtolower(trim($_POST['email']));
		$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';

		if (empty($email))
			$this->flash_and_quit("error", "Invalid E-mail.");

		$userModel = new UserModel(Database::getInstance());
		$user = $userModel->findByEmail($email);

		if (!$user)
			$this->flash_and_quit("error", "User does not exist.");

		$token = bin2hex(random_bytes(32));
		$expiry = date('Y-m-d H:i:s', time() + 900);

		$userModel->setResetToken($email, $token, $expiry);

		$message = $this->sendResetEmail($email, $token);

		$this->flash_and_quit("success", $message);

		// $message = "Password reset mail was sent";

		// View::render('auth/forgot', compact('title', 'message'));
	}

	public function sendResetEmail($email, $token)
	{
		// $subject = "Reset your email.";
		// $headers = 'From: webmaster@example.com' . "\r\n" .
        //    'Reply-To: webmaster@example.com' . "\r\n" .
        //    'X-Mailer: PHP/' . phpversion();
		// $sent = mail($email, $subject, $token, $headers);
		// var_dump($sent);
		return ("https://localhost:8443/reset?token=" . $token);
	}

	function reset()
	{
		$title = "Camagraou - Forgot Password ?";

		$token = $_GET['token'] ?? '';
		$errors = [];

		if (!$token)
		{
			$errors = ["No token was given."];
			return ;
		}

		$userModel = new UserModel(Database::getInstance());
		$user = $userModel->findByToken($token);

		if (!$user)
		{
			$errors = ["Invalid link."];
			return ;		
		}

		$expiry = strtotime($user['reset_token_expiry']);

		if ($expiry < time())
		{
			$errors = ["Token expired."];
			return ;
		}
		View::render('auth/reset_form', compact('title', 'token'));
	}

	function updatePassword()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$token = $_POST['token'] ?? '';
			$password = $_POST['password'] ?? '';
			$confirm = $_POST['confirm'] ?? '';

			// add verif maybe ?

			$userModel = new UserModel(Database::getInstance());
        	$user = $userModel->findByToken($token);

			$hash = password_hash($password, PASSWORD_DEFAULT);

			$userModel->updatePassword($user['id'], $hash);

			$errors = ["Password successfuly been changed."];
			View::render('login', compact('errors'));
		}
	}
}
