<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\CommentModel;
use App\Models\ImageModel;
use App\Models\UserModel;
use App\Core\Database;
use App\Helpers\Mail;

class CommentController extends Controller
{
	public function commentForm()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user']) || !$_SESSION['user']['is_active'])
		{
			header('Location: ' . BASE_URL . 'image?id=' . $_POST['image_id']);
			exit ;
		}

		$comment = trim($_POST['comment']);

		if (!empty($comment))
		{
			$commentModel = new CommentModel(Database::getInstance());

			$commentModel->create([
				'user_id' => $_SESSION['user']['id'],
				'image_id' => $_POST['image_id'],
				'content' => $comment
			]);

			$imageModel = new ImageModel(Database::getInstance());
			$userModel = new UserModel(Database::getInstance());

			$image = $imageModel->getImageById($_POST['image_id']);
			if ($image)
			{
				$user = $userModel->findById($image['user_id']);
				if ($user && $user['mail_notif'] && $user['id'] != $_SESSION['user']['id'])
					$this->sendCommentNotif($user['email'], $_SESSION['user']['pseudo'], $_POST['image_id']);
			}
		}
		
		header('Location: ' . BASE_URL . 'image?id=' . $_POST['image_id']);
		exit ;
	}

	private function sendCommentNotif($email, $pseudo, $imageId)
	{
		$subject = "You just received a new comment";
		$message = $pseudo . " just commented an image of yours\r\n" . 
					"https://localhost:8443/image?id=" . $imageId . "\r\n";

		Mail::send($email, $subject, $message);
	}
}
