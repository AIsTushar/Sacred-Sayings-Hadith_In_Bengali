<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="./css/home.css" />
  <link rel="stylesheet" href="./css/all_posts.css" />
  <link rel="stylesheet" href="./css/utilities.css" />
  <link rel="stylesheet" href="./css/variables.css" />
  <link rel="stylesheet" href="./css/nav.css" />
  <link rel="stylesheet" href="./css/footer.css" />
  <title>সব || হাদিস</title>
</head>

<body>
  <nav>
    <div class="nav__items-left">
      <a class="logo" href="home.php">// পবিত্র উক্তি </a>
      <div class="search_box">
        <form id="searchForm" method="POST">
          <input type="text" id="searchInput" name="searchInput" placeholder="অনুসন্ধান করুন" />
        </form>
      </div>

    </div>
    <div class="nav__items-right">
      <a class="nav-item" href="home.php">হোম</a>

      <?php if (isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])) {

        echo '<a class="nav-item" href="profile.php"><img class="nav-user-img" src="./public/users/' . $_SESSION["img"] . '"></a>';
        echo '<a class="nav-item" href="./php/logout.php">লগ আউট </a>';

      } else {
        echo '<a class="nav-item btn btn-login" href="loginSignup.php"> লগইন </a>';
        echo '<a class="nav-item btn btn-signup" href="loginSignup.php?tab=signup"> সাইন আপ </a>';
      } ?>
      <!-- <a class="nav-item btn btn-login" href="loginSignup.php"> LOG IN </a>
    <a class="nav-item btn btn-signup" href="#"> SIGN UP </a> -->
    </div>
  </nav>
  <main>
    <h2 class="searched_text"></h2>
    <h2 data-query="all-courses" class="searched_text">
      "সব হাদিস" এর ফলাফল।
    </h2>
    <div class="customization">
      <div class="cus_con_single filter_container">
        <p>
          <span class="material-symbols-outlined">filter_list</span>
          ফিল্টার
        </p>
        <select name="filter" id="filter">
          <option value="all-catagories">সব ধরনের</option>
          <option value="knowledge">Knowledge</option>
          <option value="Prayer Times">Prayers Times</option>
          <option value="The Two Festivals">The Two Festivals</option>
          <option value="Fasting">Fasting</option>
          <option value="Sales and Trade">Sales and Trade</option>
          <option value="Partnership">Partnership</option>
        </select>
      </div>
      <div class="cus_con_single sort_container">
        <p>
          <span class="material-symbols-outlined">sort</span>
          ক্রমানুসার
        </p>
        <select name="sort" id="sort">
          <option value="none">None</option>
          <option value="alphabetical">Alphabetical Sorting</option>
          <option value="category">Category Sorting</option>
          <option value="relevance">Relevance Sorting</option>
        </select>
      </div>

      <div id="apply_filter" class="cus_con_single">
        <p class="clear_filter">
          <span class="material-symbols-outlined">frame_inspect</span>
          ফিল্টার প্রয়োগ করুন
        </p>
      </div>
      <div id="clear_filter" class="cus_con_single">
        <p class="clear_filter">
          <span class="material-symbols-outlined">delete</span>
          ফিল্টার সাফ করুন
        </p>
      </div>
    </div>
  </main>
  <!-- Main part -->
  <main class="section__courses">
    <div class="course__container" id="course-container">
      <!-- Card part -->
      <!-- Card part -->
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

      // SQL query to select data from the 'hadith' table
      $sql = "SELECT hadith.*, categories.category_name
                    FROM hadith
                    INNER JOIN categories ON hadith.category_id = categories.category_id
                    LIMIT 16";

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


          echo '<p>' . $row['abstract'] . '</p>';
          echo '</div>';
        }
      } else {
        echo "No records found in the 'hadith' table.";
      }

      // Close the database connection
      $conn->close();
      ?>
      <!-- Card part end -->
    </div>
  </main>
  <!-- Footer -->
  <!-- Footer Section -->
  <?php include_once('footer.php'); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const filterSelect = document.getElementById('filter');
      const sortSelect = document.getElementById('sort');
      const applyFilterButton = document.getElementById('apply_filter');
      const clearFilterButton = document.getElementById('clear_filter');
      const courseContainer = document.getElementById('course-container');
      const searchForm = document.getElementById('searchForm');
      const searchInput = document.getElementById('searchInput');

      // Function to fetch and update the course data based on selected filter and sort options
      function updateCourseData() {
        const filterValue = filterSelect.value;
        const sortValue = sortSelect.value;

        // You can use AJAX or fetch to send a request to the server (PHP) to update the course data
        // Example: Fetch data from PHP script with query parameters filterValue and sortValue
        fetch(`filter_php_script.php?filter=${filterValue}&sort=${sortValue}`)
          .then(response => response.text())
          .then(data => {
            courseContainer.innerHTML = data; // Update the course container with new data
          })
          .catch(error => {
            console.error("Fetch Error:", error);
          });
      }

      // Event listeners for filter and sort options
      filterSelect.addEventListener('change', updateCourseData);
      sortSelect.addEventListener('change', updateCourseData);

      // Event listener for applying filters
      applyFilterButton.addEventListener('click', updateCourseData);

      // Event listener for clearing filters
      clearFilterButton.addEventListener('click', function () {
        filterSelect.value = 'all-catagories';
        sortSelect.value = 'none';
        updateCourseData();
      });

      // Function to handle form submission and perform the search
      function performSearch(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        const searchValue = searchInput.value.trim();
        console.log("Search Query:", searchValue);

        // You can use AJAX or fetch to send a request to the server (PHP) to perform the search
        // Example: Fetch data from PHP script with the search query parameter
        fetch(`search_php_script.php?query=${encodeURIComponent(searchValue)}`)
          .then(response => response.json()) // Parse the response as JSON
          .then(data => {
            if (data.length > 0) {
              // Display search results
              courseContainer.innerHTML = '';

              data.forEach(item => {
                const courseCard = document.createElement('div');
                courseCard.className = 'course_card';

                // Add content to the course card
                courseCard.innerHTML = `
                <div class="image_container">
                  <a href="#">
                    <img src="./public/${item.category_name}.jpeg" alt="Thumbnail" />
                  </a>
                </div>
                <a class="course_title" href="post_details.php?id=${item.hadith_id}">
                  <h3>${item.title}</h3>
                </a>
                <p>${item.abstract}</p>
              `;

                courseContainer.appendChild(courseCard);
              });
            } else {
              // No search results found, display a message
              courseContainer.innerHTML = '<p>No search results found.</p>';
            }
          })
          .catch(error => {
            console.error("Fetch Error:", error);
          });
      }

      // Event listener for search input changes
      searchInput.addEventListener('input', performSearch);

      // Event listener for form submission
      searchForm.addEventListener('submit', performSearch);

      // Initial data load
      updateCourseData();
    });
  </script>

</body>

</html>