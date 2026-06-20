<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\LikeModel;
use App\Core\Database;

class LikeController extends Controller
{
	public function likeImage()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image_id']) && isset($_SESSION['user']['id']))
		{
			$user_id = $_SESSION['user']['id'];
			$image_id = $_POST['image_id'];

			$likeModel = new LikeModel(Database::getInstance());

			if ($likeModel->alreadyLike($user_id, $image_id))
				$likeModel->unLike($user_id, $image_id);
			else
				$likeModel->Like($user_id, $image_id);
		}
		header('Location: ' . BASE_URL . 'image?id=' . $_POST['image_id']);
		exit ;
	}
}