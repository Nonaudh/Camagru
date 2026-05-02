<?php
$servername = "localhost";
$username = $(DB_USER);
$password = $(DB_PASS);
$dbname = $(DB_NAME);

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Could not connect. " . $e->getMessage());
}

try {
  // sql to create table
  $sql = "CREATE TABLE MyGuests (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  email VARCHAR(50),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  $conn->exec($sql);
  echo "Table created successfully";
} catch(PDOException $e) {
  echo "Error creating table: " . $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>