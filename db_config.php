<?php
// Start the session to keep the user logged in across pages
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "rakula_agency";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set charset to handle special characters correctly
mysqli_set_charset($conn, "utf8mb4");
?>