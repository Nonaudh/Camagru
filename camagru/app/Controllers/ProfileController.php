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

	private function actualizePseudo($pseudo, $user, $userModel)
	{
		if (empty($pseudo))
			$this->flash_and_quit("error", "Pseudo is needed.", "profile");
		if (strlen($pseudo) < 4 || strlen($pseudo) > 255)
			$this->flash_and_quit("error", "Pseudo need to have between 4 and 255 caracters.", "profile");
		if ($pseudo === $user['pseudo'])
			$this->flash_and_quit("error", "Same pseudo by the way", "profile");
		if ($userModel->pseudoAlreadyTaken($user['id'], $pseudo))
			$this->flash_and_quit("error", "Pseudo Already Taken", "profile");

		$userModel->updatePseudo($user['id'], $pseudo);
		$_SESSION['user']['pseudo'] = $pseudo;
		unset($_SESSION['old']);
		$this->flash_and_quit("success", "Your username has been successfully changed", "profile");
	}

	private function actualizeEmail($email, $user, $userModel)
	{
		if (empty($email))
			$this->flash_and_quit("error", "Email is needed.", "profile");
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255)
			$this->flash_and_quit("error", "Invalid Email.", "profile");
		if ($email === $user['email'])
			$this->flash_and_quit("error", "Same email by the way", "profile");
		if ($userModel->emailAlreadyTaken($user['id'], $email))
			$this->flash_and_quit("error", "Email Already Taken", "profile");

		$verification_token = bin2hex(random_bytes(32));
		$token_expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

		$userModel->updateEmail($user['id'], $email, $verification_token, $token_expiry);
		unset($_SESSION['old']);
		$_SESSION['user']['is_active'] = 0;
		if (DEVELOPMENT == true)
			$this->flash_and_quit("success", "https://localhost:8443/verify?token=" . $verification_token, "");
		// EMAIL
		$this->flash_and_quit("success", "A email was sent to you to activate your account", "");
	}

	private function actualizePassword($password, $confim, $user, $userModel)
	{
		if (empty($password))
			$this->flash_and_quit("error", "Password is needed.", "profile");
		elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,255}$/', $password))
			$this->flash_and_quit("error", "Password need to have between 4 and 255 caracters, an uppercase letter and a number.", "profile");
			
		if ($password !== $confim)
			$this->flash_and_quit("error", "Passwords does not matches.", "profile");

		$hachedPassword = password_hash($password, PASSWORD_DEFAULT);

		$userModel->updatePassword($user['id'], $hachedPassword);
		unset($_SESSION['old']);
		$this->flash_and_quit("success", "Your password has been successfully changed", "profile");
	}

	private function actualizeMailNotif($user, $userModel)
	{
		$userModel->updateMailNotif($user['id'], !$user['mail_notif']);
		unset($_SESSION['old']);
		$_SESSION['user']['mail_notif'] = !$user['mail_notif'];
		$this->flash_and_quit("success", "Your mail notification setting has been successfully changed", "profile");
	}

	public function profile()
	{
		$_SESSION['old'] = $_POST;

		if (!isset($_SESSION['user']) || !$_SESSION['user']['is_active'])
			$this->flash_and_quit("error", "Error !", "profile");

		$userModel = new UserModel(Database::getInstance());

		$user = $userModel->findById($_SESSION['user']['id']);

		if (!$user)
			$this->flash_and_quit("error", "Error !", "profile");

		if (isset($_POST['new_pseudo']))
			$this->actualizePseudo(trim($_POST['new_pseudo']), $user, $userModel);
		if (isset($_POST['new_email']))
			$this->actualizeEmail(strtolower(trim($_POST['new_email'])), $user, $userModel);
		if (isset($_POST['new_password']) && isset($_POST['confirm_new_password']))
			$this->actualizePassword($_POST['new_password'], $_POST['confirm_new_password'], $user, $userModel);
		if (isset($_POST['mail_notif']))
			$this->actualizeMailNotif($user, $userModel);

		$this->flash_and_quit("error", "wtf", "profile");
	}
}
