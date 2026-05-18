<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\User;
use App\Core\Database;

class AuthController extends Controller
{
	public function forgotForm()
	{
		$title = "Camagraou - Forgot Password ?";
		$desc = "Reset your password by entering your e-mail.";

		View::render("forgot", compact('title', 'desc'));
	}

	public function handleForgot()
	{
		$title = "Camagraou - Forgot Password ?";

		$email = strtolower(trim($_POST['email']));
		$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';

		if (empty($email))
		{
			$error = "Please enter a valid email address.";
			View::render('forgot', compact('title', 'error'));
			return ;
		}

		$userModel = new User(Database::getInstance());
		$user = $userModel->findByEmail($email);

		if (!$user)
		{
			$message = "User does not exist.";
			View::render('forgot', compact('title', 'message'));
			return ;
		}

		$token = bin2hex(random_bytes(32));
		$expiry = date('Y-m-d H:i:s', time() + 900);

		$userModel->setResetToken($email, $token, $expiry);

		$this->sendResetEmail($email, $token);

		$message = "Password reset mail was sent";

		View::render('forgot', compact('title', 'message'));
	}

	public function sendResetEmail($email, $token)
	{
		$subject = "Reset your email.";
		$headers = 'From: webmaster@example.com' . "\r\n" .
           'Reply-To: webmaster@example.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
		$sent = mail($email, $subject, $token, $headers);
		var_dump($sent);
	}
}
