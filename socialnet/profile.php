<?php
session_start();
include("db.php");

// CHECK LOGIN
if (!isset($_SESSION["username"])) {
    header("Location: signin.php");
    exit;
}

// INCLUDE MENU
include("menu.php");

// GET OWNER FROM URL
$owner = $_GET["owner"] ?? $_SESSION["username"];

// QUERY USER
$sql = "SELECT * FROM account WHERE username='$owner'";
$result = $conn->query($sql);

// CHECK USER EXIST
if ($result->num_rows == 0) {
    echo "<h2>User not found</h2>";
    exit;
}

$user = $result->fetch_assoc();
?>

<h2>👤 User Profile</h2>

<?php
if ($user["avatar"] != "") {
    echo "<img src='" . $user["avatar"] . "' width='150'><br><br>";
}
?>

<p>
<b>Username:</b>
<?= $user["username"] ?>
</p>

<p>
<b>Fullname:</b>
<?= $user["fullname"] ?>
</p>

<p>
<b>Description:</b>
<?= $user["description"] ?>
</p>
