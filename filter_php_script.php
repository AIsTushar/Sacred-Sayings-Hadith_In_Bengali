<?php
// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// Get filter and sort parameters from the URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all-catagories';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'none';

// Construct the SQL query based on filter and sort parameters
$sql = "SELECT hadith.*, categories.category_name
        FROM hadith
        INNER JOIN categories ON hadith.category_id = categories.category_id";

// Apply filters based on the filter parameter
if ($filter !== 'all-catagories') {
  $sql .= " WHERE categories.category_name = '$filter'";
}

// Apply sorting based on the sort parameter
if ($sort === 'alphabetical') {
  $sql .= " ORDER BY hadith.title ASC";
} elseif ($sort === 'category') {
  $sql .= " ORDER BY categories.category_name ASC";
} elseif ($sort === 'relevance') {
  // Add your relevance sorting logic here
}

// Limit the number of results
$sql .= " LIMIT 16";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Loop through the rows of data and generate HTML output
  while ($row = $result->fetch_assoc()) {
    echo '<div class="course_card">';
    echo '<div class="image_container">';
    echo '<a href="#">';
    echo '<img src="./public/' . $row['category_name'] . '.jpeg" alt="Thumb Nail" />';
    echo '</a>';
    echo '</div>';

    // Add a link to post_details.php with the 'id' parameter
    echo '<a class="course_title" href="post_details.php?id=' . $row['hadith_id'] . '">';
    echo '<h3>' . $row['title'] . '</h3>';
    echo '</a>';

    // Display the category name
    echo '<p>' . $row['abstract'] . '</p>';
    echo '</div>';
  }
} else {
  echo "No records found based on the selected filter and sorting.";
}

// Close the database connection
$conn->close();
?>