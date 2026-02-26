<?php
include "config.php";

$query = "
SELECT orders.*, users.username 
FROM orders 
JOIN users ON orders.user_id = users.id
WHERE orders.status = 'Pending'
ORDER BY orders.created_at DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="pen.css">
</head>
<body>

<div class="page-container">

    <h1>Pending Orders</h1>

    <button class="btn btn-back" onclick="window.location='dashboard.php'">← Back to Dashboard</button>

    <div class="table-card">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>ORD-<?= $row['id']; ?></td>
                    <td><?= date("Y-m-d h:i A", strtotime($row['created_at'])); ?></td>
                    <td class="status pending"><?= $row['status']; ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td>₱<?= number_format($row['total_amount'], 2); ?></td>
                    <td>
                        <a href="complete.php?id=<?= $row['id']; ?>" class="btn btn-action">Complete</a>
                        <a href="cancel.php?id=<?= $row['id']; ?>" class="btn btn-action">Cancel</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>