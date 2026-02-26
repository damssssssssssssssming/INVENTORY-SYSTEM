<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $orderId = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id=$orderId");
    header("Location: apen.php");
    exit();
}

$orders = $conn->query("SELECT * FROM orders 
                        WHERE status='Pending' 
                        ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pending Orders</title>
<link rel="stylesheet" href="apen.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Pending Orders</h1>
        <button class="back-btn" onclick="window.location='ad.php'">← Back to Dashboard</button>
    </div>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search orders..." onkeyup="searchOrders()"/>
    </div>

    <div class="table-card">
        <table class="orders-table" id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Shift</th>
                    <th>User ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= date("M d, Y h:i A", strtotime($row['created_at'])); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= htmlspecialchars($row['shift']); ?></td>
                    <td><?= $row['user_id']; ?></td>
                    <td>
                        <a href="view_order.php?id=<?= $row['id']; ?>" class="btn btn-blue">View</a>
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-red" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function searchOrders() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('ordersTable');
    const trs = table.getElementsByTagName('tr');

    for (let i = 1; i < trs.length; i++) {
        let tdArr = trs[i].getElementsByTagName('td');
        let match = false;

        for (let j = 0; j < tdArr.length - 1; j++) {
            if (tdArr[j].innerText.toLowerCase().includes(filter)) {
                match = true;
                break;
            }
        }

        trs[i].style.display = match ? '' : 'none';
    }
}
</script>

</body>
</html>