<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $current = $_POST['current'];
    $newPass = $_POST['newPass'];
    $confirm = $_POST['confirm'];
    $username = $_SESSION['username'];

    if ($newPass !== $confirm) {
        $message = "New passwords do not match!";
    } else {

        $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($current, $user['password'])) {

            $hashed = password_hash($newPass, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password=? WHERE username=?");
            $update->bind_param("ss", $hashed, $username);

            if ($update->execute()) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error updating password.";
            }

            $update->close();

        } else {
            $message = "Current password is incorrect!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link rel="stylesheet" href="change-password.css">
</head>
<body>

<div class="page-container">
  <div class="page-header">
    <h1>Change Password</h1>
    <button class="back-btn" onclick="window.location.href='dashboard.php'">← Back to Dashboard</button>
  </div>

  <form class="form-card" method="POST">
    <input type="password" name="current" placeholder="Current Password" required>
    <input type="password" name="newPass" placeholder="New Password" required>
    <input type="password" name="confirm" placeholder="Confirm New Password" required>

    <div class="button-group">
      <button type="submit" class="btn save">Update Password</button>
      <button type="button" class="btn cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
    </div>
  </form>

  <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

</div>

</body>
</html>