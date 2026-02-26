<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$products = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link rel="stylesheet" href="inv.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Inventory</h1>
        <button class="back-btn" onclick="window.location='dashboard.php'">← Back to Dashboard</button>
    </div>

    <div class="table-card">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Available Quantity</th>
                    <th>Stock Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= $row['quantity']; ?></td>
                        <td>
                            <?php
                                if ($row['quantity'] == 0) {
                                    echo "<span class='stock-out'>Out of Stock</span>";
                                } elseif ($row['quantity'] <= 5) {
                                    echo "<span class='stock-low'>Low Stock</span>";
                                } else {
                                    echo "<span class='stock-ok'>In Stock</span>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>