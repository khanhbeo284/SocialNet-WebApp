<?php
$host = "localhost";
$user = "socialuser";
$pass = "123456";
$db   = "socialnet";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
