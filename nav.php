<nav>
  <div class="nav__items-left">
    <a class="logo" href="home.php">// পবিত্র উক্তি </a>
    <div class="search_box">
      <form method="POST">
        <input type="text" placeholder="অনুসন্ধান করুন" />
      </form>
    </div>
  </div>
  <div class="nav__items-right">
    <a class="nav-item" href="home.php">হোম</a>
    <a class="nav-item" href="#categories">বিভাগ</a>
    <a class="nav-item" href="#top-hadiths">হাদিস</a>
    <a class="nav-item" href="#contact">যোগাযোগ</a>
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