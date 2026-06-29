<?php

namespace App\Helpers;

class Mail
{
	public static function send($email, $subject, $message)
	{
		$headers = 'From: camagru@42.fr' . "\r\n" .
			'Reply-To: camagru@42.fr' . "\r\n" .
			'X-Mailer: PHP/' . phpversion() . "\r\n" .
			'MIME-Version: 1.0' . "\r\n" .
			'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		return (mail($email, $subject, $message, $headers));
	}

}
