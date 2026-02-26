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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string(trim($_POST['fullname']));
    $role = $conn->real_escape_string($_POST['role']);
    $shift = $conn->real_escape_string($_POST['shift']);
    $status = $conn->real_escape_string($_POST['status']);

    if (empty($fullname) || empty($role) || empty($shift) || empty($status)) {
        $error = "Please fill in all required fields.";
    } else {
        $updateSql = "UPDATE users SET 
                      fullname='$fullname', 
                      role='$role', 
                      shift='$shift', 
                      status='$status' 
                      WHERE id=$id";

        if ($conn->query($updateSql)) {
            $success = "User updated successfully.";
            // Refresh user data after update
            $userResult = $conn->query("SELECT * FROM users WHERE id=$id");
            $user = $userResult->fetch_assoc();
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User</title>
<link rel="stylesheet" href="edu.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Edit User</h1>
        <button class="back-btn" onclick="window.location='aman.php'">← Back to Manage Users</button>
    </div>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form id="editUserForm" method="POST" class="form-card" autocomplete="off">
        <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']); ?>" placeholder="Full Name" required />
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" disabled />

        <select name="role" required>
            <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="staff" <?= ($user['role'] === 'staff') ? 'selected' : '' ?>>Staff</option>
            <option value="user" <?= ($user['role'] === 'user') ? 'selected' : '' ?>>User</option>
        </select>

        <select name="shift" required>
            <option value="Morning" <?= ($user['shift'] === 'Morning') ? 'selected' : '' ?>>Morning</option>
            <option value="Evening" <?= ($user['shift'] === 'Evening') ? 'selected' : '' ?>>Evening</option>
            <option value="Night" <?= ($user['shift'] === 'Night') ? 'selected' : '' ?>>Night</option>
        </select>

        <select name="status" required>
            <option value="Active" <?= ($user['status'] === 'Active') ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= ($user['status'] === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
        </select>

        <div class="button-group">
            <button type="submit" class="btn update">Update User</button>
            <button type="button" class="btn cancel" onclick="window.location='aman.php'">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>