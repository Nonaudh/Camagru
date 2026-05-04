<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// This PHP backend example processes GET and POST requests.

header('Content-Type: text/html; charset=utf-8');

echo "<h1>PHP Backend Request Processor</h1>";

// Process GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	require_once __DIR__ . '/../dbl/connection.php';
    echo "<h2>Processing GET Request</h2>";
    if (isset($_GET['username_get']) && !empty($_GET['username_get'])) {
        $username = htmlspecialchars($_GET['username_get']); // Sanitize input
        echo "<p>Hello, <strong>" . $username . "</strong>! You submitted data via GET.</p>";
        echo "<p>Full GET data: ";
        print_r($_GET); // For debugging, shows all GET parameters
        echo "</p>";
    } else {
        echo "<p>No username found in GET request.</p>";
    }
}

echo "<hr>";

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	require_once __DIR__ . '/../dbl/connection.php';
    echo "<h2>Processing POST Request</h2>";
    if (isset($_POST['username_post']) && !empty($_POST['username_post'])) {
        $username = htmlspecialchars($_POST['username_post']); // Sanitize input
        $email = isset($_POST['email_post']) ? htmlspecialchars($_POST['email_post']) : 'N/A';
        echo "<p>Hello, <strong>" . $username . "</strong>!</p>";
        echo "<p>Your email is: <strong>" . $email . "</strong></p>";
        echo "<p>You submitted data via POST.</p>";
        echo "<p>Full POST data: ";
        print_r($_POST); // For debugging, shows all POST parameters
        echo "</p>";
    } else {
        echo "<p>No username found in POST request.</p>";
    }
}
// header("Location: index.php");

echo "<p><a href='form.html'>Go back to form</a></p>";

?>
