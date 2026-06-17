<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\ImageModel;
use App\Core\Database;

class HomeController extends Controller
{
	public function index() : void
	{
		$title = "Camagraou";
		$flash = Flash::get();

		$imageModel = new ImageModel(Database::getInstance());

		// $images = $imageModel->getAllImages();

		View::render('home/index', compact('title', 'flash'));
	}

	public function getPictures()
	{
		if (!isset($_GET['last_id']))
		{
			echo json_encode([
				'error' => true
			]);
			return ;
		}

		$last_id = $_GET['last_id'];

		$imageModel = new ImageModel(Database::getInstance());

		$images = $imageModel->getImageLastId($last_id);

		echo json_encode([
			'images' => $images,
			'last_id' => $last_id + 8
		]);
	}
}
