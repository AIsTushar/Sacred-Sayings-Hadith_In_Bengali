<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';


// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check if the connection is successful
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// Check if the required POST parameters are set
if (isset($_POST['user_id'], $_POST['hadith_id'], $_POST['interaction_type'])) {
  // Get POST data
  $user_id = $_POST['user_id'];
  $hadith_id = $_POST['hadith_id'];
  $interaction_type = $_POST['interaction_type'];

  // Prepare and execute the SQL INSERT statement
  $sql = "INSERT INTO User_Hadith_Interactions (user_id, hadith_id, interaction_type) VALUES (?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    // Bind the parameters
    $stmt->bind_param("iis", $user_id, $hadith_id, $interaction_type);

    // Execute the statement
    if ($stmt->execute()) {
      echo "Interaction recorded successfully.";
    } else {
      echo "Error recording interaction: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
  } else {
    echo "Error preparing statement: " . $conn->error;
  }
} else {
  echo "Invalid request. Missing POST parameters.";
}

// Close the database connection
$conn->close();
?>