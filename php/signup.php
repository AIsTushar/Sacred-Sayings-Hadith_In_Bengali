<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {

  include_once('db_config.php');

  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  $name = trim($name);
  $email = trim($email);


  $name_pattern = "/^[a-zA-Z ]+$/";
  $email_pattern = "/^\S+@\S+\.\S+$/";
  $password_pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/";

  $errors = [];

  // Validate name
  if (!preg_match($name_pattern, $name)) {
    $errors[] = "Invalid name. Only letters and spaces are allowed.";
  }

  // Validate email
  if (!preg_match($email_pattern, $email)) {
    $errors[] = "Invalid email address.";
  }

  // Validate if email already exists 
  $emailCheck = "SELECT * FROM Users WHERE email='$email'";
  $result = $conn->query($emailCheck);
  if ($result->num_rows > 0) {
    $errors[] = "Email already exists.";
  }


  // Validate password
  if (!preg_match($password_pattern, $password)) {
    $errors[] = "Invalid password. It must contain at least one digit, one lowercase letter, one uppercase letter, and be 8 or more characters long.";
  }

  // Check if passwords match
  if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
  }

  if (empty($errors)) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database 
    $sql = "INSERT INTO Users (username, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
      $_SESSION["signupSuccess"] = "Signed up successfully!";
      header("Location: ../loginSignup.php");

    } else {
      $errors[] = $conn->error;
      $error_message = implode("\n", $errors);
      $_SESSION["error"] = $error_message;
      exit();

    }

    // Redirect to a success page or handle errors
  } else {
    // Display error messages in an alert
    $error_message = implode("\n", $errors);
    $_SESSION["error"] = $error_message;
    header("Location: ../loginSignup.php");
    exit();
  }

  $conn->close();


}
?>