<?php
session_start();

$user_id = $_SESSION["user_id"];
// Update user name, email, and photo part.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userInfo"])) {


  $user_name = $_POST["name"];
  $useremail = $_POST["email"];

  include_once('db_config.php');

  $name_pattern = "/^[a-zA-Z ]+$/";
  $email_pattern = "/^\S+@\S+\.\S+$/";

  $errors = [];

  // Validate name
  if (!preg_match($name_pattern, $user_name)) {
    $errors[] = "Invalid name. Only letters and spaces are allowed.";
  }

  // Validate email
  if (!preg_match($email_pattern, $useremail)) {
    $errors[] = "Invalid email address.";
  }

  // Validate if email already exists
  $emailCheck = "SELECT * FROM Users WHERE email=? and user_id != ?";
  $stmt = $conn->prepare($emailCheck);
  $stmt->bind_param("ss", $useremail, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $errors[] = "Email already exists.";
  }

  if (empty($errors)) {
    if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
      // Specify the target directory for saving user photos
      echo "<script>console.log('test');</script>";
      $targetDirectory = "../public/users/";

      // Get the file extension
      $fileExtension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);

      // Generate a unique filename based on user ID
      $filename = "user-" . $user_id . "." . $fileExtension;

      // Move the uploaded file to the target directory
      $targetPath = $targetDirectory . $filename;

      if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
        // Update the user's photo file name in the database
        $sql = "UPDATE Users SET img=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
          die("Error preparing the SQL statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $filename, $user_id);
        if (!$stmt->execute()) {
          die("Error updating the database: " . $stmt->error);
        }

        // Success message
        $_SESSION["img"] = $filename;
      }
    } else {
      $errors[] = "Error uploading the photo.";
    }
  }

  if (empty($errors)) {

    // Update user information in the database
    $sql = "UPDATE Users SET username=?, email=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_name, $useremail, $user_id);

    if ($stmt->execute()) {
      $_SESSION["username"] = $user_name;
      $_SESSION["email"] = $useremail;
      $_SESSION["userInfo_updated"] = "true";
      header("Location: ../profile.php");
      exit();
    } else {
      $errors[] = "Error updating user information: " . $stmt->error;
    }
  }

  // Handle errors
  if (!empty($errors)) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();

    session_start();
    $error_message = implode("\n", $errors);
    $_SESSION["error"] = $error_message;

    header("Location: ../loginSignup.php");
    exit();
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {

  $current_password = $_POST["current_password"];
  $new_password = $_POST["new_password"];
  $confirm_password = $_POST["confirm_password"];

  $password_change_message = [];

  include_once('db_config.php');

  $password_pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/";

  // Validate password
  if (!preg_match($password_pattern, $new_password)) {
    $password_change_message[] = "Invalid password. It must contain at least one digit, one lowercase letter, one uppercase letter, and be 8 or more characters long.";
  }


  // Check if the new password matches the confirmation password
  if ($new_password != $confirm_password) {
    $password_change_message[] = "New password and confirmation password do not match.";
  } else {
    // Fetch the hashed current password from the database
    $fetch_password_sql = "SELECT password FROM users WHERE user_id = $user_id";
    $result = $conn->query($fetch_password_sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $hashed_current_password = $row["password"];

      // Verify the current password
      if (password_verify($current_password, $hashed_current_password)) {
        // Hash the new password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_password_sql = "UPDATE users SET password = '$new_password_hash' WHERE user_id = $user_id";

        if ($conn->query($update_password_sql) === TRUE) {
          // Unset all session variables
          session_unset();

          // Destroy the session
          session_destroy();
          session_start();
          // Redirect to the Home page
          $_SESSION["password_change_message"] = "Password changed successfully!";
          header("Location: ../loginSignup.php");
          exit();

        } else {
          $password_change_message[] = "Error updating password: " . $conn->error;
        }
      } else {
        $password_change_message[] = "Current password is incorrect.";
      }
    } else {
      $password_change_message[] = "User not found.";
    }

    $_SESSION["password_change_message"] = $password_change_message;
    header("Location: ../profile.php");

    // Close the database connection
    $conn->close();
  }
}

?>