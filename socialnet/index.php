<?php
session_start();
include("db.php");

// CHECK LOGIN
if (!isset($_SESSION["username"])) {
    header("Location: signin.php");
    exit;
}

$currentUser = $_SESSION["username"];

// GET CURRENT USER INFO
$sqlMe = "SELECT * FROM account WHERE username='$currentUser'";
$meResult = $conn->query($sqlMe);
$me = $meResult->fetch_assoc();

?>

<?php include("menu.php"); ?>

<h2>🏠 SocialNet Home</h2>

<!-- CURRENT USER INFO -->

<?php
if ($me["avatar"] != "") {
    echo "<img src='" . $me["avatar"] . "' width='120'><br><br>";
}
?>

<p>
<b>Username:</b>
<?= $me["username"] ?>
</p>

<p>
<b>Fullname:</b>
<?= $me["fullname"] ?>
</p>

<p>
<b>Description:</b>
<?= $me["description"] ?>
</p>

<hr>

<h3>📩 Friend Requests</h3>

<?php

$requestSql = "
SELECT * FROM friend
WHERE receiver='$currentUser'
AND status='pending'
";

$requestResult = $conn->query($requestSql);

if ($requestResult->num_rows == 0) {

    echo "No friend requests.";

} else {

    while ($request = $requestResult->fetch_assoc()) {

        $sender = $request["sender"];

        echo "
        <div style='margin-bottom:10px;'>

            <b>$sender</b>

            |

            <a href='profile.php?owner=$sender'>
            View Profile
            </a>

            |

            <a href='acceptfriend.php?sender=$sender'>
            Accept Friend
            </a>

        </div>
        ";
    }
}
?>

<hr>

<h3>👥 Friend List</h3>

<?php

$sqlFriend = "
SELECT * FROM friend
WHERE status='accepted'
AND (
    sender='$currentUser'
    OR receiver='$currentUser'
)
";

$friendResult = $conn->query($sqlFriend);

if ($friendResult->num_rows == 0) {

    echo "No friends yet.";

} else {

    while ($friend = $friendResult->fetch_assoc()) {

        $friendName = ($friend["sender"] == $currentUser)
            ? $friend["receiver"]
            : $friend["sender"];

        echo "
        <div style='margin-bottom:10px;'>

            <b>$friendName</b>

            →

            <a href='profile.php?owner=$friendName'>
            View Profile
            </a>

            |

            <a href='removefriend.php?friend=$friendName'>
            Remove Friend
            </a>

        </div>
        ";
    }
}
?>

<hr>

<h3>➕ People You May Know</h3>

<?php

$sqlUsers = "
SELECT * FROM account
WHERE username != '$currentUser'
";

$usersResult = $conn->query($sqlUsers);

while ($row = $usersResult->fetch_assoc()) {

    $otherUser = $row["username"];

    // CHECK RELATIONSHIP
    $checkSql = "
    SELECT * FROM friend
    WHERE (sender='$currentUser' AND receiver='$otherUser')
       OR (sender='$otherUser' AND receiver='$currentUser')
    ";

    $checkResult = $conn->query($checkSql);

    // SHOW ONLY IF NO RELATIONSHIP
    if ($checkResult->num_rows == 0) {

        echo "
        <div style='margin-bottom:15px;'>
        ";

        // SHOW AVATAR
        if ($row["avatar"] != "") {

            echo "
            <img src='{$row["avatar"]}' width='80'><br>
            ";
        }

        echo "
            <b>{$row["username"]}</b>
            ({$row["fullname"]})

            <br>

            <a href='profile.php?owner={$row["username"]}'>
            View Profile
            </a>

            |

            <a href='addfriend.php?friend={$row["username"]}'>
            Add Friend
            </a>

        </div>
        ";
    }

    // SHOW PENDING SENT REQUEST
    else {

        $relation = $checkResult->fetch_assoc();

        if (
            $relation["sender"] == $currentUser
            && $relation["status"] == "pending"
        ) {

            echo "
            <div style='margin-bottom:15px;'>

                <b>{$row["username"]}</b>

                <br>

                Friend Request Sent ⏳

            </div>
            ";
        }
    }
}
?>
