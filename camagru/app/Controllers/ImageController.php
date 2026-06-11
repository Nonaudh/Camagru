<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\ImageModel;
use App\Core\Database;

class ImageController extends Controller
{
	public function index() : void
	{
		$title = "Camagraou";
		$flash = Flash::get();

		$imageModel = new ImageModel(Database::getInstance());

		$image = $imageModel->getImageById($_GET['id']);

		if (!$image)
		{
			header('Location: ' . BASE_URL . 'error404');
			exit ;
		}

		View::render('image', compact('title', 'flash', 'image'));
	}
}
