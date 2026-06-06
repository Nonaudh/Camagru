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

		$images = $imageModel->getAllImages();

		View::render('home/index', compact('title', 'flash', 'images'));
	}
}
