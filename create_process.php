<?php
include "config.php";

$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];
$shift = $_POST['shift'];

$check = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "Username already exists!";
} else {

    $sql = "INSERT INTO users (fullname, username, password, shift, role)
            VALUES ('$fullname', '$username', '$password', '$shift', 'user')";

    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully! <br><a href='login.php'>Login Here</a>";
    } else {
        echo "Error creating account.";
    }
}

$conn->close();
?>