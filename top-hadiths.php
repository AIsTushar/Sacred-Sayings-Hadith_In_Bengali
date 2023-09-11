<!-- Section Courses -->


<main class="section__courses">
  <h2>শীর্ষ হাদিস</h2>
  <div class="course__container">
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

    if (isset($_SESSION['user_id'])) {
      // SQL query for logged-in users
      $sql = "SELECT h.hadith_id, h.title, h.abstract, h.category_id, c.category_name
      FROM Hadith h
      INNER JOIN Categories c ON h.category_id = c.category_id
      INNER JOIN Tags_Hadith th ON h.hadith_id = th.hadith_id
      WHERE th.tag_id IN (
          SELECT th.tag_id
          FROM Tags_Hadith th
          JOIN (
              SELECT th.tag_id, COUNT(uhi.hadith_id) AS tag_view_count
              FROM Tags_Hadith th
              JOIN User_Hadith_Interactions uhi ON th.hadith_id = uhi.hadith_id
              WHERE uhi.interaction_type = 'viewed' AND uhi.user_id = $_SESSION[user_id]
              GROUP BY th.tag_id
              ORDER BY tag_view_count DESC
              LIMIT 8
          ) top_tags ON th.tag_id = top_tags.tag_id
      )
      LIMIT 8;";
    } else {
      // SQL query for users who are not logged in
      $sql = "SELECT h.hadith_id, h.title, h.abstract, h.category_id, c.category_name
      FROM Hadith h
      INNER JOIN Categories c ON h.category_id = c.category_id
      LIMIT 4;";
    }





    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Loop through the rows of data and display them in your HTML structure
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
        // echo '<p>Category: ' . $row['category_name'] . '</p>';
        echo '<p>' . $row['abstract'] . '</p>';
        echo '</div>';
      }

      if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        echo '<h3 style="width: 400%;">শীর্ষ হাদিস - আরো দেখতে লগইন করুন</h3>';
      }


    } else {
      $sql = "SELECT h.hadith_id, h.title, h.abstract, h.category_id, c.category_name
      FROM Hadith h
      INNER JOIN Categories c ON h.category_id = c.category_id
      LIMIT 4;";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {

        // Loop through the rows of data and display them in your HTML structure
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
          // echo '<p>Category: ' . $row['category_name'] . '</p>';
          echo '<p>' . $row['abstract'] . '</p>';
          echo '</div>';
        }
        echo '<h3 style="width: 400%;">শীর্ষ হাদিস - আরো দেখতে আরো ব্যবহার করুন</h3>';

      } else {
        echo "0 results";
      }



    }

    // Close the database connection
    $conn->close();

    ?>
  </div>
  <a class="btn-more" href="All_hadith.php">আরো দেখুন-></a>
</main>