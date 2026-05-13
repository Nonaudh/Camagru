<?php

use PDO;

abstract class BaseModel
{
	protected PDO $db;
	protected string $table;

	public function __construct(PDO $db)
	{
		$this->db = $db;	
	}

	public function findAll(): array
	{
		$stmt = $this->db->query("SELECT * FROM {$this->table}");
		return ($stmt->fetchAll(PDO::FETCH_ASSOC));
	}
}
