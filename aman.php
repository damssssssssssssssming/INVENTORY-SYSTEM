<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: aman.php");
    exit();
}

$users = $conn->query("SELECT * FROM users ORDER BY fullname ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
<link rel="stylesheet" href="aman.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Manage Users</h1>
        <button class="back-btn" onclick="window.location='ad.php'">← Back to Dashboard</button>
    </div>

    <div class="button-group">
        <button class="btn add" onclick="window.location='adu.php'">+ Add User</button>
    </div>

    <div class="table-card">
        <table class="users-table" id="usersTable">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Shift</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['fullname']); ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['role']); ?></td>
                    <td><?= htmlspecialchars($row['shift']); ?></td>
                    <td>
                        <a href="edu.php?id=<?= $row['id']; ?>" class="btn btn-blue">Edit</a>
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-red" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelector('.back-btn').addEventListener('click', () => {
    window.location = 'ad.php';
});
</script>

</body>
</html>