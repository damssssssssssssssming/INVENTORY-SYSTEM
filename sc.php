<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_shift'])) {
    $name = $_POST['shift_name'] ?? '';
    $start = $_POST['start_time'] ?? '';
    $end = $_POST['end_time'] ?? '';

    if ($name && $start && $end) {
        $stmt = $conn->prepare("INSERT INTO shifts (shift_name, start_time, end_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $start, $end);
        $stmt->execute();
    }
    header("Location: shift_config.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM shifts WHERE id=$id");
    header("Location: shift_config.php");
    exit();
}

$shifts = $conn->query("SELECT * FROM shifts ORDER BY start_time ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Shift Configuration</title>
<link rel="stylesheet" href="combined.css">
</head>
<body>
<div class="page-container">
    <div class="page-header">
        <h1>Shift Configuration</h1>
        <button class="back-btn" onclick="window.location='ad.php'">← Back to Dashboard</button>
    </div>

    <div class="button-group">
        <button class="btn add" onclick="document.getElementById('addShiftForm').style.display='block'">+ Add Shift</button>
    </div>

    <div class="table-card">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Shift Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $shifts->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['shift_name'] ?? '—'); ?></td>
                    <td><?= htmlspecialchars($row['start_time'] ?? '—'); ?></td>
                    <td><?= htmlspecialchars($row['end_time'] ?? '—'); ?></td>
                    <td>
                        <a href="edit_shift.php?id=<?= $row['id']; ?>" class="btn btn-blue">Edit</a>
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-red" onclick="return confirm('Delete this shift?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div id="addShiftForm" class="form-card" style="display:none; margin-top:20px;">
        <h3>Add New Shift</h3>
        <form method="POST">
            <input type="text" name="shift_name" placeholder="Shift Name" required>
            <input type="time" name="start_time" required>
            <input type="time" name="end_time" required>
            <div class="button-group">
                <button type="submit" name="add_shift" class="btn save">Save Shift</button>
                <button type="button" class="btn cancel" onclick="document.getElementById('addShiftForm').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>