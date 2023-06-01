<?php
// Database configuration
$db_host = "localhost"; // Update with your database host
$db_user = "root"; // Update with your database username
$db_password = ""; // Update with your database password
$db_name = "dairym"; // Update with your database name

// Establish database connection
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>