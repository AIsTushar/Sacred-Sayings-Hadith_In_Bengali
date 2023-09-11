<?php
// Remove or comment out this debugging line
// echo "Reached PHP script";
error_reporting(0);


$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

if (isset($_GET['category_id'])) {
  $category_id = $_GET['category_id'];

  // Fetch tags related to the selected category
  $query = "SELECT tag_id, tag_name FROM Tags INNER JOIN Categories_Tags ON Tags.tag_id = Categories_Tags.tag_id WHERE Categories_Tags.category_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $category_id);
  $stmt->execute();

  $result = $stmt->get_result();

  $tags = [];
  while ($row = $result->fetch_assoc()) {
    $tags[] = $row;
  }

  echo json_encode($tags);
}

$conn->close();
?>