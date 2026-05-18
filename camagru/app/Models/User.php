<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User extends BaseModel
{
	protected string $table = 'users';

	public function checkExistingEmailAndPseudo($email, $pseudo) : array
	{
		$sql = "SELECT email, pseudo FROM users WHERE email = :email OR pseudo = :pseudo";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(['email' => $email, 'pseudo' => $pseudo]);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$emailExist = false;
		$pseudoExist = false;

		foreach ($result as $row)
		{
			if ($row['email'] === $email)
				$emailExist = true;
			if ($row['pseudo'] === $pseudo)
				$pseudoExist = true;
		}

		return ([
			'email' => $emailExist,
			'pseudo' => $pseudoExist
		]);
	}

	public function create($data)
	{
		$db = $this->db;

		$sql = "INSERT INTO users (
			email,
			password,
			pseudo
			) VALUES (
			:email,
			:password,
			:pseudo
			)";

		$stmt = $db->prepare($sql);

		if (!$stmt && DEVELOPMENT == true)
			die("Error user create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'email' => $data['email'],
				'password' => $data['password'],
				'pseudo' => $data['pseudo']
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

	public function findByEmail(string $email) : ?array
	{
		$sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return ($user ?: null);
	}

	public function setResetToken($email, $token, $expiry)
	{
		$sql = "UPDATE users SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':token', $token);
		$stmt->bindValue(':expiry', $expiry);
		$stmt->bindValue(':email', $email);
		$stmt->execute();
	}
}
