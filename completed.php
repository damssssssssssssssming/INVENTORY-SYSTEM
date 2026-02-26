<?php
include "config.php";

$query = "
SELECT orders.*, users.username 
FROM orders 
JOIN users ON orders.user_id = users.id
WHERE orders.status = 'Completed'
ORDER BY orders.created_at DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Completed Orders</title>
    <link rel="stylesheet" href="com.css">
</head>
<body>

<div class="page-container">

    <div class="action-buttons">
        <button class="btn-back" onclick="window.location='dashboard.php'">← Back to Dashboard</button>
    </div>

    <h1>Completed Orders</h1>

    <div class="table-card">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>ORD-<?= $row['id']; ?></td>
                            <td><?= date("Y-m-d h:i A", strtotime($row['created_at'])); ?></td>
                            <td>
                                <span class="status completed"><?= $row['status']; ?></span>
                            </td>
                            <td><?= $row['username']; ?></td>
                            <td>₱<?= number_format($row['total_amount'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            No completed orders found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>