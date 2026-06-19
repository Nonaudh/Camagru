<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Helpers\Flash;
use App\Models\ImageModel;
use App\Core\Database;

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

		if (isset($_FILES['fileInput']))
		{
			$tmp_name = $_FILES['fileInput']['tmp_name'];
			$file_name = $_FILES['fileInput']['name'];
			$folder = '/var/www/html/public/images/';

			if (!move_uploaded_file($tmp_name, $folder . $file_name))
				die ('Error');

			$imageModel = new ImageModel(Database::getInstance());

			$imageModel->create([
				'user_id' => $_SESSION['user']['id'],
				'filename' => $tmp_name,
				'filepath' => '/images/' . $file_name
			]);

			echo json_encode([
				'success' => true,
				'file' => $file_name
			]);
		}
	}

	public function capture()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST')
			exit ;

		$data = json_decode(file_get_contents('php://input'), true);

		$img = $data['image'];

		$img = str_replace('data:image/jpeg;base64,', '', $img);

		$binary = base64_decode($img);

		$id = uniqid();

		$filename = '/var/www/html/public/images/' . $id . '.jpeg';

		$filepath = '/images/' . $id . '.jpeg';

		if (!file_put_contents($filename, $binary))
			die ('Error');

		$img = imagecreatefromjpeg($filename);

		$sticker = imagecreatefrompng('/var/www/html/public/' . str_replace('https://localhost:8443/', '', $data['sticker']));

		imagecopy($img, $sticker, $data['x'] * imagesx($img), $data['y'] * imagesy($img), 0, 0, imagesx($sticker), imagesy($sticker));

		imagejpeg($img, $filename, 90);

		$imageModel = new ImageModel(Database::getInstance());

		$imageModel->create([
			'user_id' => $_SESSION['user']['id'],
			'filename' => $filename,
			'filepath' => $filepath
		]);


		imagedestroy($img);
		imagedestroy($sticker);

		echo json_encode([
			'success' => true
		]);
	}

	public function getThumbnails()
	{
		$imageModel = new ImageModel(Database::getInstance());

		$images = $imageModel->getImageForThumbnails($_SESSION['user']['id']);
	
		foreach ($images as $image)
		{
			// echo '<a href= "image?id=' . htmlspecialchars($image['id']) .'">';
			echo '<img src= "' . htmlspecialchars($image['filepath']) . '">';
			// echo '</a>';
		}
	}

	public function deleteImage()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		$imgFilePath = str_replace('https://localhost:8443', '', $data['image']);

		$imageModel = new ImageModel(Database::getInstance());

		$imageModel->deleteImageByFilepath($imgFilePath);
	}
}
