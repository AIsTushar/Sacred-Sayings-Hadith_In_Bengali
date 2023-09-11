<!-- Show message -->
<?php
session_start();

// Show error message
if (isset($_SESSION["error"])) {
  $error_message = $_SESSION["error"];
  echo "<script>alert('$error_message');</script>";
  unset($_SESSION["error"]);
}
// Show signup success message
if (isset($_SESSION["signupSuccess"])) {
  $signupSuccess = $_SESSION["signupSuccess"];
  echo "<script>alert('$signupSuccess');</script>";
  unset($_SESSION["signupSuccess"]);
}

// Password change success message
if (isset($_SESSION["password_change_message"])) {
  $password_change_message = $_SESSION["password_change_message"] . " " . "Please login again.";
  echo "<script>alert('$password_change_message');</script>";
  unset($_SESSION["password_change_message"]);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/variables.css">
  <link rel="stylesheet" href="./css/loginSignup.css" />
  <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/footer.css">
  <script src="https://unpkg.com/ionicons@latest/dist/ionicons.js"></script>

  <title>লগইন || সাইন আপ</title>
</head>

<body>

  <nav>
    <div class="nav__items-left">
      <a class="logo" href="./home.php">// পবিত্র উক্তি </a>
      <div class="search_box">
        <form method="POST">
          <input type="text" placeholder="অনুসন্ধান করুন" />
        </form>
      </div>
    </div>
    <div class="nav__items-right">
      <a class="nav-item" href="home.php">হোম</a>

    </div>
  </nav>

  <div class="sign-up-body">

    <div class="container <?php echo isset($_GET["tab"]) && ($_GET["tab"] === "signup") ? "right-panel-active" : ""; ?>"
      id="container">

      <div class="form-container sign-up-container">
        <!-- Signup Form -->
        <form action="./php/signup.php" method="POST">
          <h1>একাউন্ট তৈরি করুন</h1>
          <div class="social-container">
            <a href="#" class="social"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#" class="social"><ion-icon name="logo-google"></ion-icon></a>
            <a href="#" class="social"><ion-icon name="logo-linkedin"></ion-icon></a>
          </div>
          <span>অথবা নিবন্ধনের জন্য আপনার ইমেল ব্যবহার করুন</span>
          <input class="form__input" type="text" name="name" placeholder="John Doe" required="required" />
          <input class="form__input" type="email" name="email" placeholder="you@example.com" required="required" />
          <input class="form__input" type="password" name="password" placeholder="• • • • • • • •" required="required"
            minlength="8" />
          <input class="form__input" type="password" name="confirm_password" placeholder="• • • • • • • •"
            required="required" minlength="8" />

          <button class="signup-btn-form" type="submit" name="signup">সাইন আপ</button>
        </form>
      </div>

      <div class="form-container sign-in-container">
        <!-- Login Form -->
        <form action="./php/login.php" method="POST">
          <h1>লগইন</h1>
          <div class="social-container">
            <a href="#" class="social"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#" class="social"><ion-icon name="logo-google"></ion-icon></a>
            <a href="#" class="social"><ion-icon name="logo-linkedin"></ion-icon></a>
          </div>
          <span>অথবা আপনার অ্যাকাউন্ট ব্যবহার করুন</span>
          <input class="form__input" type="email" name="email" placeholder="you@example.com" required="required" />
          <input class="form__input" type="password" name="password" placeholder="• • • • • • • •" required="required"
            minlength="8" />
          <a href="#">আপনি কি পাসওয়ার্ড ভুলে গেছেন?</a>
          <button type="submit" name="login">লগইন</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>স্বাগতম!</h1>
            <p>
              আমাদের সাথে সংযুক্ত থাকতে আপনার ব্যক্তিগত তথ্য দিয়ে লগইন করুন
            </p>
            <button class="ghost" id="signIn">লগইন</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>হ্যালো বন্ধু!</h1>
            <p>আপনার ব্যক্তিগত বিবরণ লিখুন এবং আমাদের সাথে যাত্রা শুরু করুন</p>
            <button class="ghost" id="signUp">সাইন আপ</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="./js/loginsignup.js"></script>
</body>



</html>