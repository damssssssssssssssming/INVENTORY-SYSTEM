<?php
include "config.php";

$username = $_POST['username'];

$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $new_password = '123456';
    $update = "UPDATE users SET password='$new_password' WHERE username='$username'";

    if ($conn->query($update) === TRUE) {
        echo "Password reset successfully! New password: 123456 <br><a href='login.php'>Login Here</a>";
    } else {
        echo "Error resetting password!";
    }

} else {
    echo "Username not found!";
}

$conn->close();
?>