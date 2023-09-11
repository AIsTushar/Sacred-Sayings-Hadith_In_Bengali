<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';

$conn = new mysqli($hostname, $username, $password, $database);


if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

?>