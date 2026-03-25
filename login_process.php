<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $shift = trim($_POST['shift']); // optional, for session

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Plain text password check
        if ($password === $user['password']) {

            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['shift'] = $shift;

            // Ensure role is set
            $role = !empty($user['role']) ? $user['role'] : 'user';

            if ($role === 'admin') {
                header("Location: ad.php");
                exit();
            } else {
                header("Location: dashboard.php");
                exit();
            }

        } else {
            echo "<script>alert('Incorrect password'); window.location='index.php';</script>";
        }

    } else {
        echo "<script>alert('User not found'); window.location='index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>