<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();


session_start();
// Redirect to the Home page
$_SESSION["logoutSuccess"] = "You have been logged out.";
header("Location: ../home.php");

exit();
?>