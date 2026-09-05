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

		if (!isset($_GET['i']) || $_GET['i'] == 'webcam')
			View::render('webcam', compact('title', 'desc'));

		else if ($_GET['i'] == 'file')
			View::render('webcamFile', compact('title', 'desc'));

		else
		{
			header('Location: ' . BASE_URL . 'error404');
			exit ;
		}
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

			$extension = pathinfo($file_name, PATHINFO_EXTENSION);
			$allowedExtensions = ['png', 'jpeg', 'jpg'];

			if (!in_array($extension, $allowedExtensions))
			{
				echo json_encode(['error' => 'extensions']);
				return ;
			}

			if ($extension == 'png')
				$img = imagecreatefrompng($tmp_name);
			if ($extension == 'jpeg' || $extension == 'jpg')
				$img = imagecreatefromjpeg($tmp_name);

			if (isset($_POST['imageWidth']))
			{
				$img = imagescale($img, (int)$_POST['imageWidth']);
			}	
			else
			{
				echo json_encode(['error' => 'no width']);
				return ;
			}

    		$stickers = [];

			if (isset($_POST['stickers']))
			{
				$stickers = json_decode($_POST['stickers'], true);
				// echo json_encode(['sticker' => var_dump($stickers)]);
			}

			foreach ($stickers as $sticker)
			{
				$src = $sticker['src'];
				$x = $sticker['x'];
				$y = $sticker['y'];

				$src = imagecreatefrompng('/var/www/html/public/' . str_replace('https://localhost:8443/', '', $src));
		
				imagecopy($img, $src, $x * imagesx($img), $y * imagesy($img), 0, 0, imagesx($src), imagesy($src));

				imagedestroy($src);

				// echo json_encode(['sticker' => $src]);
			}

			$file_name = uniqid() . '.' . $extension;

			imagejpeg($img, $folder . $file_name , 90);

			$imageModel = new ImageModel(Database::getInstance());

			$imageModel->create([
				'user_id' => $_SESSION['user']['id'],
				'filepath' => '/images/' . $file_name
			]);
		}
		else
		{
			echo json_encode(['error' => 'no file Input']);
			return ;
		}
	}

	public function capture()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST')
			exit ;

		$data = json_decode(file_get_contents('php://input'), true);

		$img = $data['image'];
		$stickers = $data['stickers'];

		$img = str_replace('data:image/jpeg;base64,', '', $img);

		$binary = base64_decode($img);

		$id = uniqid();

		$filename = '/var/www/html/public/images/' . $id . '.jpeg';

		$filepath = '/images/' . $id . '.jpeg';

		if (!file_put_contents($filename, $binary))
			die ('Error : file_put_contents');

		$img = imagecreatefromjpeg($filename);

		foreach ($stickers as $sticker)
		{
			$src = $sticker['src'];
			$x = $sticker['x'];
			$y = $sticker['y'];

			$src = imagecreatefrompng('/var/www/html/public/' . str_replace('https://localhost:8443/', '', $src));
	
			imagecopy($img, $src, $x * imagesx($img), $y * imagesy($img), 0, 0, imagesx($src), imagesy($src));

			imagedestroy($src);
		}

		imagejpeg($img, $filename, 90);

		$imageModel = new ImageModel(Database::getInstance());

		$imageModel->create([
			'user_id' => $_SESSION['user']['id'],
			'filepath' => $filepath
		]);

		imagedestroy($img);
	}

	public function getThumbnails()
	{
		$imageModel = new ImageModel(Database::getInstance());

		$images = $imageModel->getImageForThumbnails($_SESSION['user']['id']);
	
		foreach ($images as $image)
		{
			echo '<img src= "' . htmlspecialchars($image['filepath']) . '">';
		}
	}

	public function deleteImage()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		$imgFilePath = str_replace('https://localhost:8443', '', $data['image']);

		$imageModel = new ImageModel(Database::getInstance());

		$image = $imageModel->getImageByFilepath($imgFilePath);

		if ($image && isset($_SESSION['user']) && $image['user_id'] == $_SESSION['user']['id'])
		{
			unlink('/var/www/html/public' . $image['filepath']);
			$imageModel->deleteImageById($image['id']);
		}
	}
}
