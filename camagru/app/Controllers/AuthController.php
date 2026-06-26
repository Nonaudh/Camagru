<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\UserModel;
use App\Core\Database;
use App\Helpers\Flash;

use Exception;

class AuthController extends Controller
{
	public function forgotForm()
	{
		$title = "Camagraou - Forgot Password ?";
		$desc = "Reset your password by entering your e-mail.";

		$flash = Flash::get();

		View::render("auth/forgot", compact('title', 'desc', 'flash'));
	}

	private function flash_and_quit($type, $message, $path)
	{
		Flash::set($type, $message);
		header('Location: ' . BASE_URL . $path);
		exit ;
	}

	public function handleForgot()
	{
		$title = "Camagraou - Forgot Password ?";

		$email = strtolower(trim($_POST['email']));
		$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';

		if (empty($email))
			$this->flash_and_quit("error", "Invalid E-mail.", "forgot");

		$userModel = new UserModel(Database::getInstance());
		$user = $userModel->findByEmail($email);

		if (!$user)
			$this->flash_and_quit("error", "User does not exist.", "forgot");

		$token = bin2hex(random_bytes(32));
		$expiry = date('Y-m-d H:i:s', time() + 900);

		$userModel->setResetToken($email, $token, $expiry);

		$message = $this->sendResetEmail($email, "https://localhost:8443/reset?token=" . $token);

		$this->flash_and_quit("success", "https://localhost:8443/reset?token=" . $token . "  " . $message, "forgot");

		// $message = "Password reset mail was sent";

		// View::render('auth/forgot', compact('title', 'message'));
	}

	public function sendResetEmail($email, $token)
	{
		$subject = "Reset your email.";
		$headers = 'From: camagru@42.fr' . "\r\n" .
			'Reply-To: camagru@42.fr' . "\r\n" .
			'X-Mailer: PHP/' . phpversion() . "\r\n" .
			'MIME-Version: 1.0' . "\r\n" .
			'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$sent = mail($email, $subject, $token, $headers);
		if (!$sent)
			throw new Exception('mail error');
		print_r($sent);
		return ($sent);
	}

	function reset()
	{
		$title = "Camagraou - Forgot Password ?";
		$flash = Flash::get();

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
		View::render('auth/reset_form', compact('title', 'token', 'flash'));
	}

	function updatePassword()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$token = $_POST['token'] ?? '';
			$password = $_POST['password'] ?? '';
			$confirm = $_POST['confirm'] ?? '';

			if (empty($password))
				$this->flash_and_quit("error", "Password is needed.", "reset?token=" . $token);
			elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password))
				$this->flash_and_quit("error", "Password need to have at least 8 caracters, an uppercase letter and a number.", "reset?token=" . $token);
			
			if ($password !== $confirm)
				$this->flash_and_quit("error", "Passwords does not matches.", "reset?token=" . $token);

			$userModel = new UserModel(Database::getInstance());
        	$user = $userModel->findByToken($token);

			if (!$user)
				$this->flash_and_quit("error", "Unexpected Error...", "reset?token=" . $token);

			$hash = password_hash($password, PASSWORD_DEFAULT);

			$userModel->updatePassword($user['id'], $hash);

			$this->flash_and_quit("success", "Password successfuly been changed.", "");
		}
	}
}
