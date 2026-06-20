<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class LikeModel extends BaseModel
{
	protected string $table = 'likes';

	public function like($user_id, $image_id)
	{
		$db = $this->db;

		$sql = "INSERT INTO {$this->table} ( user_id, image_id) 
				VALUES (:user_id, :image_id)";

		$stmt = $db->prepare($sql);

		if (!$stmt && DEVELOPMENT == true)
			die("Error likes create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'user_id' => $user_id,
				'image_id' => $image_id
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

	public function unlike($user_id, $image_id)
	{
		$db = $this->db;

		$sql = "DELETE FROM {$this->table} WHERE user_id = :user_id AND image_id = :image_id";

		$stmt = $db->prepare($sql);

		if (!$stmt && DEVELOPMENT == true)
			die("Error likes create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'user_id' => $user_id,
				'image_id' => $image_id
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

	public function alreadyLike($user_id, $image_id)
	{
		$db = $this->db;

		$sql = "SELECT 1 FROM {$this->table} WHERE user_id = :user_id AND image_id = :image_id LIMIT 1";

		$stmt = $db->prepare($sql);
		if (!$stmt && DEVELOPMENT == true)
			die("Error likes create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'user_id' => $user_id,
				'image_id' => $image_id
			]);

			return ($stmt->fetchColumn() === 1);
		}		
		catch (PDOException $e)
		{
			if (DEVELOPMENT == true)
				echo $e->getMessage();
			return (false);
		}
	}

	public function getLikes($image_id)
	{
		$db = $this->db;

		$sql = "SELECT COUNT(*) FROM {$this->table} WHERE image_id = :image_id";

		$stmt = $db->prepare($sql);
		if (!$stmt && DEVELOPMENT == true)
			die("Error likes create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'image_id' => $image_id
			]);

			return ($stmt->fetchColumn());
		}		
		catch (PDOException $e)
		{
			if (DEVELOPMENT == true)
				echo $e->getMessage();
			return (false);
		}
	}
}
