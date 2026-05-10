<?php
session_start();
include("db.php");

// LOGIN
if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "
    SELECT * FROM account
    WHERE username='$username'
    AND password='$password'
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $_SESSION["username"] = $username;

        header("Location: index.php");
        exit;

    } else {

        $loginError = "Invalid username or password";
    }
}

// REGISTER
if (isset($_POST["register"])) {

    $username = $_POST["new_username"];
    $password = $_POST["new_password"];
    $fullname = $_POST["fullname"];

    // CHECK USER EXIST
    $check = "
    SELECT * FROM account
    WHERE username='$username'
    ";

    $checkResult = $conn->query($check);

    if ($checkResult->num_rows > 0) {

        $registerError = "Username already exists";

    } else {

        $sql = "
        INSERT INTO account(username, password, fullname)
        VALUES('$username', '$password', '$fullname')
        ";

        $conn->query($sql);

        $registerSuccess = "Account created successfully";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SocialNet Login</title>
</head>

<body>

<h1>🌐 SocialNet</h1>

<table width="100%" border="1" cellpadding="20">

<tr>

<!-- LOGIN -->

<td width="50%" valign="top">

<h2>🔐 Login</h2>

<?php
if (isset($loginError)) {
    echo "<p style='color:red;'>$loginError</p>";
}
?>

<form method="POST">

    <p>
    Username:
    <br>
    <input type="text" name="username" required>
    </p>

    <p>
    Password:
    <br>
    <input type="password" name="password" required>
    </p>

    <button type="submit" name="login">
        Login
    </button>

</form>

</td>

<!-- REGISTER -->

<td width="50%" valign="top">

<h2>🆕 Create Account</h2>

<?php
if (isset($registerError)) {
    echo "<p style='color:red;'>$registerError</p>";
}

if (isset($registerSuccess)) {
    echo "<p style='color:green;'>$registerSuccess</p>";
}
?>

<form method="POST">

    <p>
    Username:
    <br>
    <input type="text" name="new_username" required>
    </p>

    <p>
    Password:
    <br>
    <input type="password" name="new_password" required>
    </p>

    <p>
    Fullname:
    <br>
    <input type="text" name="fullname" required>
    </p>

    <button type="submit" name="register">
        Create Account
    </button>

</form>

</td>

</tr>

</table>

</body>
</html>
