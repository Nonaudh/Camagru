<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\ImageModel;
use App\Models\CommentModel;
use App\Models\LikeModel;
use App\Core\Database;

class ImageController extends Controller
{
	public function index() : void
	{
		$title = "Camagraou";
		$flash = Flash::get();

		$imageModel = new ImageModel(Database::getInstance());

		$image = $imageModel->getImageById($_GET['id']);

		$commentModel = new CommentModel(Database::getInstance());

		$comments = $commentModel->getCommentsOfAnImage($_GET['id']);

		$likeModel = new LikeModel(Database::getInstance());

		$likes = $likeModel->getLikes($_GET['id']);

		$user_has_liked = 0;

		if (isset($_SESSION['user']) && $_SESSION['user']['is_active'])
			$user_has_liked = $likeModel->alreadyLike($_SESSION['user']['id'], $_GET['id']);

		if (!$image)
		{
			header('Location: ' . BASE_URL . 'error404');
			exit ;
		}

		View::render('image', compact('title', 'flash', 'image', 'comments', 'likes', 'user_has_liked'));
	}
}
