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
		{
			$pseudo = trim($_POST['new_pseudo']);

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
			$this->flash_and_quit("success", "Pseudo successfully modify", "profile");
		}
		$this->flash_and_quit("error", "wtf", "profile");
	}
}
