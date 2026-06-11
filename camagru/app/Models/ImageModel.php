<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class ImageModel extends BaseModel
{
	protected string $table = 'images';

	public function create($data)
	{
		$db = $this->db;

		$sql = "INSERT INTO images ( user_id, filename, filepath) 
				VALUES (:user_id, :filename, :filepath)";

		$stmt = $db->prepare($sql);

		if (!$stmt && DEVELOPMENT == true)
			die("Error image create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'user_id' => $data['user_id'],
				'filename' => $data['filename'],
				'filepath' => $data['filepath']
			]);

			$data['id'] = $db->lastInsertId();

			return ($data);
		}
		catch (PDOException $e)
		{
			if (DEVELOPMENT == true)
				echo $e->getMessage();
			return (false);
		}
	}

	public function getAllImages()
	{
		$sql = 'SELECT * FROM images ORDER BY created_at DESC';
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$images = $stmt->fetchAll();

		return ($images ?? null);
	}

	public function getImageForThumbnails($user_id)
	{
		$sql = 'SELECT * FROM images WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 8';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$images = $stmt->fetchAll();

		return ($images ?? null);
	}

	public function getImageById($id)
	{
		$sql = "SELECT * FROM images WHERE id = :id LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$image = $stmt->fetch(PDO::FETCH_ASSOC);

		return ($image ?: null);
	}
}
