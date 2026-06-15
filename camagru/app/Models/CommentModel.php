<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class CommentModel extends BaseModel
{
	protected string $table = 'comments';

	public function create($data)
	{
		$db = $this->db;

		$sql = "INSERT INTO comments ( user_id, image_id, content) 
				VALUES (:user_id, :image_id, :content)";

		$stmt = $db->prepare($sql);

		if (!$stmt && DEVELOPMENT == true)
			die("Error comment create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'user_id' => $data['user_id'],
				'image_id' => $data['image_id'],
				'content' => $data['content']
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

	public function getCommentsOfAnImage($image_id)
	{
		$sql = 'SELECT comments.content, comments.created_at, users.pseudo
				FROM comments
				JOIN users ON comments.user_id = users.id
				WHERE comments.image_id = :image_id
				ORDER BY comments.created_at DESC';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
		$stmt->execute();
		$comments = $stmt->fetchAll();

		return ($comments ?? null);
	}
}