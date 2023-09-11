<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
  // Include your database connection code here
  include_once('db_config.php');


  // Sanitize and validate form data
  $email = $_POST["email"];
  $password = $_POST["password"];

  $email = trim($email);

  // Prepare a SQL statement using a prepared statement
  $sql = "SELECT * FROM Users WHERE email = ?";
  $stmt = $conn->prepare($sql);

  if ($stmt === false) {
    die("Error in preparing the SQL statement: " . $conn->error);
  }

  // Bind the email parameter to the prepared statement
  $stmt->bind_param("s", $email);

  // Execute the prepared statement
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Fetch the user data
  $row = $result->fetch_assoc();

  if ($row) {
    // User found, you can access user_id and user_type
    $user_id = $row["user_id"];
    $username = $row["username"];
    $userEmail = $row["email"];
    $user_type = $row["user_type"];
    $img = $row["img"];
    $hashedPasswordFromDatabase = $row["password"];
  } else {
    // User not found, handle the case here
    $_SESSION["error"] = "User not found";
    header("Location: ../loginSignup.php");
    exit();
  }

  // Close the prepared statement
  $stmt->close();


  // Verify the password using password_verify
  if (password_verify($password, $hashedPasswordFromDatabase)) {
    // Login successful
    $_SESSION["loginSuccess"] = "Login successful";
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $userEmail;
    $_SESSION["user_type"] = $user_type;
    $_SESSION["img"] = $img;


    header("Location: ../home.php");
    exit();
  } else {
    // Login failed
    $_SESSION["error"] = "Login failed";
    header("Location: ../loginSignup.php");
    exit();
  }
}
?>