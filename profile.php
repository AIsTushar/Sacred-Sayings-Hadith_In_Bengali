<?php

session_start();

if (isset($_SESSION["hadit_add_success"])) {
  echo "<script>alert(" . json_encode($_SESSION["hadit_add_success"]) . ");</script>";
  unset($_SESSION["hadit_add_success"]);
}

if (isset($_SESSION["password_change_message"])) {
  $message = $_SESSION["password_change_message"];
  echo "<script>alert(" . json_encode($message) . ");</script>";
  unset($_SESSION["password_change_message"]);
}

if (isset($_SESSION["userInfo_updated"])) {
  echo "<script>alert('User info updated');</script>";
  unset($_SESSION["userInfo_updated"]);

}

// Check if the user is logged in
if (isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])) {
  $user_id = $_SESSION["user_id"];
  $user_type = $_SESSION["user_type"];
  $username = $_SESSION["username"];
  $useremail = $_SESSION["email"];
  $img = $_SESSION["img"];
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="./css/profile.css" />
  <link rel="stylesheet" href="./css/variables.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/utilities.css" />
  <link rel="stylesheet" href="./css/nav.css">

  <!-- <script defer src="./js/profile.js"></script> -->


  <title>&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;আমি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|</title>
</head>

<body>
  <nav>
    <div class="nav__items-left">
      <a class="logo" href="home.php">// পবিত্র উক্তি </a>
      <div class="search_box">
        <form method="POST">
          <input type="text" placeholder="SEARCH" />
        </form>
      </div>
    </div>
    <div class="nav__items-right">
      <a class="nav-item" href="home.php">হোম</a>
      <a class="nav-item" href="#">বিভাগ</a>
      <a class="nav-item" href="#">হাদিস</a>
      <a class="nav-item" href="#">যোগাযোগ</a>
      <a class="nav-item" href="./php/logout.php">লগ আউট </a>
    </div>
  </nav>

  <main class="main">
    <div class="user-view">
      <div class="user-view__menu">
        <ul class="side-nav">
          <li class="side-nav--active" id="user-account--section--clicked">
            <a href="#"> <svg></svg>অ্যাকাউন্ট</a>
          </li>

          <?php
          if ($user_type == 'admin') {
            // Admin part
            echo '<li id="users--section--clicked">
              <a href="#"><svg></svg>ইউসার</a>
          </li>
          <li id="post--clicked">
              <a href="#"><svg></svg>পোস্ট</a>
          </li>
          <li id="message--clicked">
              <a href="#"><svg></svg>বার্তা</a>
          </li>';
          }
          ?>

        </ul>
      </div>

      <!-- Left side -->
      <div class="user-view__content">

        <!-- When Account button is clicked -->
        <div class="user-account--section-clicked">
          <div class="user-view__form-container">
            <h2 class="heading-secondary ma-bt-md">আপনার অ্যাকাউন্ট সেটিংস</h2>
            <!-- Account setting form -->
            <form class="form form-user-data" action="./php/update_user.php" method="POST"
              enctype="multipart/form-data">
              <div class="form__group">
                <label class="form__label" for="name">নাম</label>
                <input class="form__input" id="name" type="text" name="name" value="<?php echo $username; ?>"
                  required="required" />
              </div>
              <div class="form__group ma-bt-md">
                <label class="form__label" for="email">ইমেইল ঠিকানা</label>
                <input class="form__input" id="email" name="email" type="email" value="<?php echo $useremail; ?>"
                  required="required" />
              </div>
              <div class="form__group form__photo-upload" id="img-input-container">
                <img class="form__user-photo" id="user-photo" src="./public/users/<?php echo $img; ?>"
                  alt="User photo" />
                <a class="btn-text" href="#" id="choose-photo-link">নতুন ছবি বেছে নিন</a>
              </div>
              <div class="form__group right">
                <button class="btn btn--small btn--green" name="userInfo" type="submit">
                  সেটিংস সংরক্ষণ করুন
                </button>
              </div>
            </form>
          </div>
          <div class="line">&nbsp;</div>
          <div class="user-view__form-container">
            <h2 class="heading-secondary ma-bt-md">পাসওয়ার্ড পরিবর্তন</h2>

            <!-- Change Password form -->
            <form class="form form-user-settings" action="./php/update_user.php" method="POST">
              <div class="form__group">
                <label class="form__label" for="password-current">বর্তমান পাসওয়ার্ড</label>
                <input class="form__input" id="password-current" name="current_password" type="password"
                  placeholder="••••••••" required="required" minlength="8" />
              </div>
              <div class="form__group">
                <label class="form__label" for="password">নতুন পাসওয়ার্ড</label>
                <input class="form__input" id="password" name="new_password" type="password" placeholder="••••••••"
                  required="required" minlength="8" />
              </div>
              <div class="form__group ma-bt-lg">
                <label class="form__label" for="password-confirm">পাসওয়ার্ড নিশ্চিত করুন</label>
                <input class="form__input" id="password-confirm" name="confirm_password" type="password"
                  placeholder="••••••••" required="required" minlength="8" />
              </div>
              <div class="form__group right">
                <button class="btn btn--small btn--green" name="change_password" type="submit">
                  পাসওয়ার্ড সংরক্ষণ
                </button>
              </div>
            </form>
          </div>
        </div>


        <!-- When Post button is clicked -->
        <!-- Post Section -->
        <!-- When Post button is clicked -->

        <div class="user-view__form-container" id="post-section" style="display: none">
          <h2 class="heading-secondary ma-bt-md">একটি নতুন হাদিস পোস্ট করুন</h2>
          <form class="form form-post-data" id="hadith-form" method="POST" action="./php/insert_hadith.php">
            <div class="form__group">
              <label class="form__label" for="hadith-title">হাদিসের শিরোনাম</label>
              <input class="form__input" id="hadith-title" name="hadith-title" type="text"
                placeholder="Enter the Hadith title" required="required" />
            </div>
            <div class="form__group">
              <label class="form__label" for="hadith-abstract">হাদিসের সারাংশ</label>
              <input class="form__input" id="hadith-abstract" name="hadith-abstract" type="text"
                placeholder="Enter a brief abstract" required="required" />
            </div>
            <div class="form__group">
              <label class="form__label" for="hadith-category">হাদিস বিভাগ</label>
              <select class="form__input" id="hadith-category" name="hadith-category" required>
                <option value="">বিভাগ নির্বাচন করুন</option>
                <?php
                $hostname = 'localhost';
                $username = 'root';
                $password = '';
                $database = 'cse479';

                $conn = new mysqli($hostname, $username, $password, $database);

                if ($conn->connect_error) {
                  die("Database connection failed: " . $conn->connect_error);
                }

                // Fetch categories from the database
                $query = "SELECT category_id, category_name FROM Categories";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                }
                ?>
              </select>
            </div>
            <!-- Dynamic tag selection -->

            <?php
            for ($i = 1; $i <= 3; $i++) {
              echo '<div class="form__group">';
              echo '<label class="form__label" for="hadith-tags-' . $i . '">Tag ' . $i . '</label>';
              echo '<select class="form__input" id="hadith-tags-' . $i . '" name="hadith-tags[]" required>';
              echo '<option value="">Select Tag ' . $i . '</option>';

              echo $_SESSION['category_id'];

              $query = "SELECT tag_id, tag_name FROM Tags";
              $result = $conn->query($query);

              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['tag_id'] . '">' . $row['tag_name'] . '</option>';
              }

              echo '</select>';
              echo '</div>';
            }
            ?>
            <div class=" form__group">
              <label class="form__label" for="hadith-details">হাদিসের বিবরণ</label>
              <textarea class="form__input" id="hadith-details" name="hadith-details"
                placeholder="Enter the full Hadith details"></textarea>
            </div>
            <button class="btn btn--small btn--green" type="submit" name="post_hadith">পোস্ট হাদিস</button>
          </form>
        </div>



        <!-- Post Section  End-->


        <!-- Show all Users Section -->
        <!-- Users Section -->

        <?php

        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'cse479';

        $conn = new mysqli($hostname, $username, $password, $database);


        if ($conn->connect_error) {
          die("Database connection failed: " . $conn->connect_error);
        }

        // Check if a user ID is provided for deletion
        if (isset($_GET['delete_user'])) {
          $deleteUserId = $_GET['delete_user'];
          // Perform the delete operation
          $deleteSql = "DELETE FROM users WHERE user_id = $deleteUserId";
          if ($conn->query($deleteSql) === TRUE) {
            echo "<script>alert('User deleted successfully');</script>";
          } else {
            echo "<script>alert('Error: " . "<br>" . $conn->error . "');</script>";
          }
        }

        // Query to retrieve user data from the 'users' table
        $sql = "SELECT * FROM users Where user_type !='admin'";
        $result = $conn->query($sql);



        ?>
        <div class="user-view__form-container" id="users-section" style="display: none">
          <h2 class="heading-secondary ma-bt-md">ইউজার ম্যানেজমেন্ট</h2>
          <table class="user-list">
            <thead>
              <tr>
                <th>ব্যবহারকারী আইডি</th>
                <th>নাম</th>
                <th>ইমেইল</th>
                <th>কর্ম</th>
              </tr>
            </thead>
            <tbody>

              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<tr class="user-item">';
                  echo '<td class="user-info">' . $row['user_id'] . '</td>';
                  echo '<td class="user-info">' . $row['username'] . '</td>';
                  echo '<td class="user-info">' . $row['email'] . '</td>';
                  echo '<td class="user-info">';
                  echo '<a href="?delete_user=' . $row['user_id'] . '" class="material-symbols-outlined"> delete </a>';
                  echo '</td>';
                  echo '</tr>';
                }
              } else {
                echo '<tr><td colspan="4">No users found</td></tr>';
              }
              ?>

            </tbody>
          </table>
          <?php
          $conn->close();
          ?>
        </div>
        <!-- Show all Users Section End -->
        <!--  -->
        <!-- Message Section start -->
        <?php
        // Assuming you have already established a database connection
        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'cse479';

        $conn = new mysqli($hostname, $username, $password, $database);


        if ($conn->connect_error) {
          die("Database connection failed: " . $conn->connect_error);
        }

        // Query to retrieve messages from the 'contact_messages' table ordered by timestamp
        $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5";
        $result = $conn->query($sql);
        ?>
        <div class="user-view__form-container" id="message-section" style="display: none">
          <h2 class="heading-secondary ma-bt-md">ব্যবহারকারীদের বার্তা</h2>
          <ul class="message-list">
            <!-- <li class="message-item">
              <span class="message-info">Name: John Doe</span>
              <span class="message-info">Email: john@example.com</span>
              <span class="message-info">Subject: Regarding Your Product</span>
              <p class="message-text">
                Message: Lorem ipsum dolor sit amet, consectetur adipiscing
                elit.
              </p>
            </li>
            <li class="message-item">
              <span class="message-info">Name: Jane Smith</span>
              <span class="message-info">Email: jane@example.com</span>
              <span class="message-info">Subject: Inquiry about Services</span>
              <p class="message-text">
                Message: Nullam in neque at lectus posuere pretium in ac est.
              </p>
            </li>
            <li class="message-item">
              <span class="message-info">Name: Alice Johnson</span>
              <span class="message-info">Email: alice@example.com</span>
              <span class="message-info">Subject: Feedback on Your Website</span>
              <p class="message-text">
                Message: Fusce viverra arcu id justo euismod, id iaculis
                ligula fringilla.
              </p>
            </li> -->
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<li class="message-item">';
                echo '<span class="message-info">Name: ' . $row['name'] . '</span>';
                echo '<span class="message-info">Email: ' . $row['email'] . '</span>';
                echo '<span class="message-info">Subject: ' . $row['subject'] . '</span>';
                echo '<p class="message-text">Message: ' . $row['message'] . '</p>';
                echo '</li>';
              }
            } else {
              echo '<li class="message-item">No messages found.</li>';
            }
            ?>

          </ul>
        </div>
        <!-- message section end -->
      </div>
    </div>
    <!-- Left side end -->
  </main>
  <?php
  include_once('footer.php');
  ?>




  <script src="./js/profile.js"></script>
</body>

</html>