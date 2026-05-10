<?php
session_start();
include("db.php");

if (!isset($_SESSION["username"])) {
    header("Location: signin.php");
    exit;
}

$currentUser = $_SESSION["username"];
$sender = $_GET["sender"];

$sql = "
UPDATE friend
SET status='accepted'
WHERE sender='$sender'
  AND receiver='$currentUser'
";

$conn->query($sql);

header("Location: index.php");
?>
