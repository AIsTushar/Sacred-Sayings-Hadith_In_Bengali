<?php
session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'cse479';

$conn = new mysqli($hostname, $username, $password, $database);


if (isset($_GET['id'])) {
  $hadith_id = $_GET['id'];

  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'cse479';

  $conn = new mysqli($hostname, $username, $password, $database);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query the database using 'hadith_id'
  $sql = "SELECT
  hadith.*,
  categories.category_name,
  GROUP_CONCAT(tags.tag_name) AS tag_names
FROM
  hadith
LEFT JOIN
  categories ON hadith.category_id = categories.category_id
LEFT JOIN
  tags_hadith ON hadith.hadith_id = tags_hadith.hadith_id
LEFT JOIN
  tags ON tags_hadith.tag_id = tags.tag_id
WHERE
  hadith.hadith_id = $hadith_id
GROUP BY
  hadith.hadith_id;
";

  // Query the database using 'hadith_id'
  $sql2 = "SELECT
  hadith.*,
  categories.category_name,
  GROUP_CONCAT(tags.tag_name) AS tag_names
FROM
  hadith
LEFT JOIN
  categories ON hadith.category_id = categories.category_id
LEFT JOIN
  tags_hadith ON hadith.hadith_id = tags_hadith.hadith_id
LEFT JOIN
  tags ON tags_hadith.tag_id = tags.tag_id
GROUP BY
  hadith.hadith_id;
";
  $result = $conn->query($sql);

  $result2 = $conn->query($sql2);



  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

  } else {
    echo "Post not found.";
  }
} else {
  echo "Invalid request. 'id' parameter is missing.";
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="./css/variables.css" />
  <link rel="stylesheet" href="./css/utilities.css">
  <link rel="stylesheet" href="./css/post_details.css" />
  <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/footer.css">

  <title>পোস্ট || বিস্তারিত</title>
</head>

<body>
  <!-- Navbar part -->

  <?php include 'nav.php'; ?>


  <!-- Post details part -->
  <div class="post_container">

    <!-- Post details part start -->
    <div class="post-details">
      <img src="./public/<?php echo htmlspecialchars($row['category_name']); ?>.jpeg" alt="Post Image"
        class="cover-photo" />

      <h1 class="post-title">
        <?php echo htmlspecialchars($row['title']); ?>
      </h1>
      <p class="post-abstract">
        <?php echo htmlspecialchars($row['abstract']); ?>
      </p>

      <!-- Assuming you have a 'tags' column in your 'hadith' table containing tags separated by commas -->
      <div class="post-tags">
        <?php
        $tags = explode(',', $row['tag_names']);
        foreach ($tags as $tag) {
          echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';
        }
        ?>
      </div>

      <div class="post-content">
        <p>
          <?php echo nl2br(htmlspecialchars($row['details'])); ?>
        </p>
      </div>
    </div>


    <!-- Post details part end -->
    <div class="related-posts">
      <h2>সম্পর্কিত পোস্ট</h2>

      <?php
      $count = 0;
      if ($result2->num_rows > 0) {
        // Loop through the rows of data and display them in your HTML structure
        while ($row = $result2->fetch_assoc()) {
          if ($count >= 2) {
            break;
          }
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

          echo '<p>' . $row['abstract'] . '</p>';

          // Display tags
          $tags = explode(',', $row['tag_names']); // Assuming 'tag_names' contains comma-separated tags
          foreach ($tags as $tag) {
            echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';

          }

          echo '</div>';
          $count++;
        }
      } else {
        echo "No records found in the 'hadith' table.";
      }
      ?>


      <!-- Add more related posts as needed -->
    </div>
  </div>


  <!-- Footer part -->
  <?php include 'footer.php'; ?>

  <!-- JavaScript code for tracking viewed interaction -->

  <?php
  if (isset($_SESSION["user_id"])) { ?>

    <script>
      setTimeout(function () {
        // This code will execute after a 10-second delay
        <?php
        // Your PHP code here
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
      
        // Get POST data
        $user_id = $_SESSION['user_id'];
        $interaction_type = "viewed";

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


        // Close the database connection
        $conn->close();

        ?>
      }, 10000); // 10,000 milliseconds = 10 seconds
    </script>

    <?php
  }

  ?>

</body>

</html>