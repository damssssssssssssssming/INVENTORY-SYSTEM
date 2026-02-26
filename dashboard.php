<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "config.php";

$totalProductsQuery = $conn->query("SELECT COUNT(*) AS total FROM products");
$totalProducts = $totalProductsQuery->fetch_assoc()['total'] ?? 0;

$availableStockQuery = $conn->query("SELECT COUNT(*) AS available FROM products WHERE quantity > 0");
$availableStock = $availableStockQuery->fetch_assoc()['available'] ?? 0;

$lowStockQuery = $conn->query("SELECT COUNT(*) AS low FROM products WHERE quantity <= 10 AND quantity > 0");
$lowStock = $lowStockQuery->fetch_assoc()['low'] ?? 0;

$pendingOrdersQuery = $conn->query("SELECT COUNT(*) AS pending FROM orders WHERE status='Pending'");
$pendingOrders = $pendingOrdersQuery->fetch_assoc()['pending'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="dash.css">
</head>
<body>

<div class="dashboard">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

    <div class="cards">
        <div class="card">
            Total Products
            <span><?php echo $totalProducts; ?></span>
        </div>
        <div class="card">
            Available Stock
            <span><?php echo $availableStock; ?></span>
        </div>
        <div class="card">
            Low Stock
            <span><?php echo $lowStock; ?></span>
        </div>
        <div class="card">
            Pending Orders
            <span><?php echo $pendingOrders; ?></span>
        </div>
    </div>

    <div class="actions">
        <button class="icon-btn" title="Create New Order" onclick="window.location.href='co.php'">
            <i class="fa-solid fa-plus"></i>
            <span>New Order</span>
        </button>
        <button class="icon-btn" title="Pending Orders" onclick="window.location.href='pending-orders.php'">
            <i class="fa-solid fa-clock"></i>
            <span>Pending</span>
        </button>
        <button class="icon-btn" title="Completed Orders" onclick="window.location.href='completed.php'">
            <i class="fa-solid fa-check"></i>
            <span>Completed</span>
        </button>
        <button class="icon-btn" title="View Inventory" onclick="window.location.href='inventory.php'">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Inventory</span>
        </button>
    </div>

    <button class="logout" onclick="window.location.href='logout.php'">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </button>
</div>

</body>
</html>