<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include("db.php");
include("menu.php");

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $description = $_POST['description'];

    $avatar = "";

    if ($_FILES['avatar']['name'] != "") {

        $avatar = "uploads/" . basename($_FILES["avatar"]["name"]);

        move_uploaded_file(
            $_FILES["avatar"]["tmp_name"],
            $avatar
        );

        $sql = "
        UPDATE account
        SET fullname='$fullname',
            description='$description',
            avatar='$avatar'
        WHERE username='$username'
        ";

    } else {

        $sql = "
        UPDATE account
        SET fullname='$fullname',
            description='$description'
        WHERE username='$username'
        ";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Setting Page</h2>

<form method="post" enctype="multipart/form-data">

    Fullname:<br>
    <input type="text" name="fullname"><br><br>

    Description:<br>
    <textarea name="description"></textarea><br><br>

    Avatar:<br>
    <input type="file" name="avatar"><br><br>

    <input type="submit" value="Update">

</form>
