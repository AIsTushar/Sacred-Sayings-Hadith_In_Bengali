<?php
// Database configuration (same as before)
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// Get the search query from the URL parameter
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Construct the SQL query for searching (modify as needed)
$sql = "SELECT hadith.*, categories.category_name
        FROM hadith
        INNER JOIN categories ON hadith.category_id = categories.category_id
        WHERE hadith.title LIKE '%$searchQuery%' OR hadith.abstract LIKE '%$searchQuery%'
        LIMIT 16";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Initialize an empty array to store search results
  $searchResults = array();

  // Loop through the rows of data and add each result to the array
  while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
  }

  // Output the search results as JSON (or format it as needed)
  echo json_encode($searchResults);
} else {
  echo "No search results found.";
}

// Close the database connection
$conn->close();
?>