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

		// phpinfo();

		View::render('home/index', compact('title', 'flash'));
	}

	public function getPictures()
	{
		$last_id = $_GET['last_id'] ?? null;

		$imageModel = new ImageModel(Database::getInstance());

		if (!$last_id)
			$images = $imageModel->getLatestImages();
		else
			$images = $imageModel->getImagesLastId($last_id);

		// var_dump($images);

		$new_last_id = !empty($images) ? end($images)['id'] : $last_id;
		$has_more = count($images) > 0;

		echo json_encode([
			'images' => $images,
			'last_id' => $new_last_id,
			'has_more' => $has_more
		]);
	}
}
