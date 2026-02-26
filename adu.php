<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string(trim($_POST['fullname']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);
    $shift = $conn->real_escape_string($_POST['shift']);

    // Basic validation
    if (empty($fullname) || empty($username) || empty($password) || empty($role) || empty($shift)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if username already exists
        $check = $conn->query("SELECT id FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Insert user
            $sql = "INSERT INTO users (fullname, username, password, role, shift) VALUES ('$fullname', '$username', '$password', '$role', '$shift')";
            if ($conn->query($sql)) {
                header("Location: aman.php");
                exit();
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add User</title>
<link rel="stylesheet" href="adu.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Add User</h1>
        <button class="back-btn" onclick="window.location='aman.php'">← Back to Manage Users</button>
    </div>

    <?php if (isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form id="addUserForm" method="POST" class="form-card" autocomplete="off">
        <input type="text" name="fullname" placeholder="Full Name" required />
        <input type="text" name="username" placeholder="Email / Username" required />
        <input type="password" name="password" placeholder="Password" required />

        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="user">User</option>
        </select>

        <select name="shift" required>
            <option value="">Select Shift</option>
            <option value="Morning">Morning</option>
            <option value="Evening">Evening</option>
            <option value="Night">Night</option>
        </select>

        <div class="button-group">
            <button type="submit" class="btn save">Save User</button>
            <button type="button" class="btn cancel" id="cancelBtn">Cancel</button>
        </div>
    </form>
</div>

<script>
document.getElementById('cancelBtn').addEventListener('click', () => {
    window.location = 'aman.php';
});
</script>

</body>
</html>