<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class ErrorController extends Controller
{
	public function notFound()
	{
		http_response_code(404);
		$title = "Error 404";
		$desc = "Sorry, Page Not Found...";
		View::render('error', compact('title', 'desc'));
	}
}
