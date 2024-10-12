<?php  
// MySQLi connection
$dbcon = mysqli_connect("localhost", "root", "", "slpolice");

if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($dbcon, 'utf8');
$conn = $dbcon; // Make sure $conn refers to the mysqli connection
?>
