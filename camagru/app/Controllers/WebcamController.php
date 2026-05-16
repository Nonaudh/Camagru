<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class WebcamController extends Controller
{
	public function index()
	{
		if (!isset($_SESSION['user']))
		{
			header('Location :'.BASE_URL.'signin');
			exit;
		}

		$title = "Webcam - Camagraou";
		$desc = "Webcam - Camagraou";

		View::render('webcam', compact('title', 'desc'));
	}
}
