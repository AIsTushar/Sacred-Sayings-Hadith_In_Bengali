<?php
session_start();
$admin_user_id = $_SESSION["user_id"];

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $hadithTitle = $_POST['hadith-title'];
  $hadithAbstract = $_POST['hadith-abstract'];
  $hadithCategory = $_POST['hadith-category'];
  $hadithTags = $_POST['hadith-tags'];
  $hadithDetails = $_POST['hadith-details'];

  // Generate image filename based on category
  $imageFilename = $hadithCategory . '.jpg';

  // Insert Hadith information into the Hadith table
  $insertHadithQuery = "INSERT INTO Hadith (title, category_id, abstract, details, admin_user_id, image) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($insertHadithQuery);
  $stmt->bind_param("sissis", $hadithTitle, $hadithCategory, $hadithAbstract, $hadithDetails, $admin_user_id, $imageFilename);

  // Suppress errors (for debugging purposes)
  $stmt->execute();

  $hadithId = $stmt->insert_id;

  foreach ($hadithTags as $tagId) {

    $stmt = $conn->prepare("INSERT INTO Tags_Hadith (tag_id, hadith_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $tagId, $hadithId);

    // Suppress errors (for debugging purposes)
    $stmt->execute();
  }

  // Redirect without displaying error
  $_SESSION["hadit_add_success"] = "Hadith added successfully";
  header("Location: ../profile.php");
  exit();
}
?>