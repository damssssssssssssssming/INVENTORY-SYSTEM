<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: aman.php");
    exit();
}

$id = intval($_GET['id']);
$error = '';
$success = '';

// Fetch user data
$userResult = $conn->query("SELECT * FROM users WHERE id=$id");
if ($userResult->num_rows === 0) {
    header("Location: aman.php");
    exit();
}
$user = $userResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_status'])) {
    $newStatus = ($user['status'] === 'Active') ? 'Inactive' : 'Active';

    if ($conn->query("UPDATE users SET status='$newStatus' WHERE id=$id")) {
        $success = "User status updated to $newStatus.";
        $user['status'] = $newStatus;
    } else {
        $error = "Failed to update user status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Activate / Deactivate User</title>
<link rel="stylesheet" href="toggle-user-status.css" />
</head>
<body>

<div class="page-container">
  <div class="page-header">
    <h1>User Status</h1>
    <button class="back-btn" onclick="window.location='aman.php'">← Back to Manage Users</button>
  </div>

  <?php if ($error): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="success-message"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <div class="status-card">
    <p><strong>Name:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
    <p>
      <strong>Status:</strong>
      <span id="status" class="status <?= strtolower($user['status']) ?>">
        <?= htmlspecialchars($user['status']) ?>
      </span>
    </p>

    <form method="POST" style="display:inline;">
      <button type="submit" name="toggle_status" id="toggleBtn" class="btn action">
        <?= ($user['status'] === 'Active') ? 'Deactivate User' : 'Activate User' ?>
      </button>
    </form>
    <button class="btn cancel" onclick="window.location='aman.php'">Cancel</button>
  </div>
</div>

</body>
</html>