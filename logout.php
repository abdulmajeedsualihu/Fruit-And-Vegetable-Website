<?php
// logout.php
session_start(); // Start the session

// Destroy the session to log the user out
session_destroy();

// Redirect to the login page
header("Location: login.php"); // Replace with your login page URL
exit();
?>
