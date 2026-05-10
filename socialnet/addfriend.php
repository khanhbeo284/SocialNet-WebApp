<?php
session_start();
include("db.php");

if (!isset($_SESSION["username"])) {
    header("Location: signin.php");
    exit;
}

$currentUser = $_SESSION["username"];
$friend = $_GET["friend"];

// NOT SELF
if ($currentUser != $friend) {

    // CHECK EXIST
    $check = "
    SELECT * FROM friend
    WHERE (sender='$currentUser' AND receiver='$friend')
       OR (sender='$friend' AND receiver='$currentUser')
    ";

    $result = $conn->query($check);

    if ($result->num_rows == 0) {

        $sql = "
        INSERT INTO friend(sender, receiver, status)
        VALUES('$currentUser', '$friend', 'pending')
        ";

        $conn->query($sql);
    }
}

header("Location: index.php");
?>
