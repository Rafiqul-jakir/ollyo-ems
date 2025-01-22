<?php
// Start the session
session_start();

// Destroy the session to log out the user
session_destroy();

// Redirect the user to the login page or home page
header("Location: index.php"); // or home.php or your desired page
exit;
