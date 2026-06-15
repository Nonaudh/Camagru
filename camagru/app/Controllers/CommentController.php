<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\CommentModel;
use App\Core\Database;

class CommentController extends Controller
{
	public function commentForm()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST')
			exit ;

		$comment = trim($_POST['comment']);

		if (!empty($comment))
		{
			$commentModel = new CommentModel(Database::getInstance());

			$commentModel->create([
				'user_id' => $_SESSION['user']['id'],
				'image_id' => $_POST['image_id'],
				'content' => $comment
			]);
		}
		header('Location: ' . BASE_URL . 'image?id=' . $_POST['image_id']);
		exit ;
	}
}
