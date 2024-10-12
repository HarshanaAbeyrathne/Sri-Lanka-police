<?php
session_start();

// Destroy the session and redirect to login page
session_destroy();

// Optionally unset the session variables (good practice)
unset($_SESSION['staffid']);
unset($_SESSION['role']);
unset($_SESSION['username']);

// Redirect to login page
header("Location: ../login.php");
exit;
?>
