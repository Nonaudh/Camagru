<?php

namespace App\Helpers;

class Flash
{
	public static function set(string $type, string $message)
	{
		$_SESSION['flash'] = [
			'type' => $type,
			'message' => $message
		];
	}

	public static function get()
	{
		if (!isset($_SESSION['flash']))
			return (null);

		$flash = $_SESSION['flash'];
		unset($_SESSION['flash']);

		return ($flash);
	}
}
