<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class UserModel extends BaseModel
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

		$sql = "INSERT INTO users (email, password, pseudo, mail_notif, is_active, verification_token, reset_token_expiry) 
				VALUES (:email, :password, :pseudo, :mail_notif, :is_active, :verification_token, :reset_token_expiry)";

		$stmt = $db->prepare($sql);

		if (!$stmt && DEVELOPMENT == true)
			die("Error user create prepare sql : " . implode(" ", $db->errorInfo()));

		try
		{
			$stmt->execute([
				'email' => $data['email'],
				'password' => $data['password'],
				'pseudo' => $data['pseudo'],
				"mail_notif" => 1,
				'is_active' => 0,
				'verification_token' => $data['verification_token'],
				'reset_token_expiry' => $data['reset_token_expiry']
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

	public function findById($id)
	{
		$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $id);
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

	public function findByToken($token)
	{
		$sql = "SELECT * FROM users WHERE reset_token = :token LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':token', $token);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return ($user ?: null);
	}

	public function updatePassword($id, $hash)
	{
		$sql = "UPDATE users SET password = :hash, reset_token = NULL, reset_token_expiry = NULL WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':hash', $hash);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function updatePseudo($id, $pseudo)
	{
		$sql = "UPDATE users SET pseudo = :pseudo WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function updateEmail($id, $email, $verification_token, $token_expiry)
	{
		$sql = "UPDATE users SET email = :email, is_active = 0, verification_token = :verification_token, reset_token_expiry = :token_expiry WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':verification_token', $verification_token);
		$stmt->bindValue(':token_expiry', $token_expiry);
		$stmt->execute();
	}

	public function updateMailNotif($id, $mail_notif)
	{
		$sql = "UPDATE users SET mail_notif = :mail_notif WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':mail_notif', $mail_notif, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function findByTokenVerify($token)
	{
		$sql = "SELECT * FROM users WHERE verification_token = :token LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':token', $token, PDO::PARAM_STR);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

    	return ($user ?: null);
	}

	public function activateAccount($id)
	{
		$sql = "UPDATE users SET is_active = 1, verification_token = NULL, reset_token_expiry = NULL WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function pseudoAlreadyTaken($id, $pseudo)
	{
		$sql = "SELECT * FROM users WHERE pseudo = :pseudo AND id != :id LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return ($user ?: null);
	}

	public function emailAlreadyTaken($id, $email)
	{
		$sql = "SELECT * FROM users WHERE email = :email AND id != :id LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return ($user ?: null);
	}
}
