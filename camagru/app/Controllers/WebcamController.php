<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;

class WebcamController extends Controller
{
	public function index()
	{
		$title = "Webcam - Camagraou";
		$desc = "Webcam - Camagraou";

		View::render('webcam', compact('title', 'desc'));
	}

	private function debug($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

	public function handleFileInput()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST')
			exit ;
		
		// $image = $_POST['fileInput'];
		// if (!$image)
		// 	echo "No Image !";

		if (isset($_FILES['fileInput']))
		{
			$tmp_name = $_FILES['fileInput']['tmp_name'];
			$file_name = $_FILES['fileInput']['name'];
			$folder = '/var/www/html/images/';

			if (move_uploaded_file($tmp_name, $folder . $file_name))
				echo "Move upload OK";
			else
				echo "Move upload CASSÉ";
		}
	}
}
