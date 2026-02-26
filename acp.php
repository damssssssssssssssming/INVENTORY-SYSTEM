<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $username = $_SESSION['username'];

    // Fetch current password hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current, $hash)) {
        $message = "Current password is incorrect.";
    } elseif ($new !== $confirm) {
        $message = "New password and confirmation do not match.";
    } else {
        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE username=?");
        $stmt->bind_param("ss", $new_hash, $username);
        $stmt->execute();
        $stmt->close();
        $message = "Password changed successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Change Password</title>
<link rel="stylesheet" href="combined.css">
</head>
<body>
<div class="page-container">
    <div class="page-header">
        <h1>Change Password</h1>
        <button class="back-btn" onclick="window.location='ad.php'">← Back to Dashboard</button>
    </div>

    <div class="form-card">
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <div class="button-group">
                <button type="submit" name="change_password" class="btn save">Change Password</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>