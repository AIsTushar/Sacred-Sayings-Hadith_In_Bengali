<?php
// Start a session 
session_start();

// Check Login successful message
if (isset($_SESSION["loginSuccess"])) {
  echo "<script>alert('$_SESSION[loginSuccess]');</script>";
  unset($_SESSION["loginSuccess"]);

}

// Check Logout message
if (isset($_SESSION["logoutSuccess"])) {
  echo "<script>alert('$_SESSION[logoutSuccess]');</script>";

  unset($_SESSION["logoutSuccess"]);
}

// Check if the user is logged in
if (isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])) {

  $user_type = $_SESSION["user_type"];
  $username = $_SESSION["username"];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="./css/home.css">
  <link rel="stylesheet" href="./css/variables.css" />
  <link rel="stylesheet" href="./css/nav.css" />
  <link rel="stylesheet" href="./css/footer.css" />
  <link rel="stylesheet" href="./css/utilities.css" />
  <title>পবিত্র উক্তি</title>
</head>

<!-- Navigation Section -->
<?php
include_once('nav.php');
?>

<!-- Hero Section -->
<?php include_once('hero.php'); ?>

<!-- Top Categories Section -->
<section id="categories">
  <?php include_once('categories.php'); ?>
</section>


<!-- Top Hadiths Section -->

<section id="top-hadiths">
  <?php include_once('top-hadiths.php'); ?>
</section>


<!-- Contact us Section -->
<section id="contact">
  <?php include_once('contact.php'); ?>
</section>


<!-- Footer Section -->
<?php include_once('footer.php'); ?>



<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function (event) {
      var target = $(this.getAttribute('href'));
      if (target.length) {
        event.preventDefault();
        $('html, body').stop().animate({
          scrollTop: target.offset().top
        }, 1000); // Adjust the duration as needed (in milliseconds)
      }
    });
  });
</script>


<body>

</body>

</html>