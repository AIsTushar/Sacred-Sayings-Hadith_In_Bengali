<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["user_id"])) {
    $id = $_POST["user_id"];

    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'cse479';


    $conn = new mysqli($hostname, $username, $password, $database);


    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    // Step 2: Delete the User
    $delete_query = "DELETE FROM users WHERE user_id = $id";
    if ($conn->query($delete_query) === TRUE) {
      echo "User with ID $user_id deleted successfully.";
    } else {
      echo "Error deleting user: " . $conn->error;
    }

    $conn->close();

  }
}
?>