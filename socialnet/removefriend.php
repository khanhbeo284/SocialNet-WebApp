<?php
session_start();
include("db.php");

if (!isset($_SESSION["username"])) {
    header("Location: signin.php");
    exit;
}

$currentUser = $_SESSION["username"];
$friend = $_GET["friend"];

// REMOVE FRIEND
$sql = "
DELETE FROM friend
WHERE (sender='$currentUser' AND receiver='$friend')
   OR (sender='$friend' AND receiver='$currentUser')
";

$conn->query($sql);

// BACK TO HOME
header("Location: index.php");
exit;
?>
