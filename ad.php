<?php
session_start();
include "config.php";

// Redirect if not logged in or not admin
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT role FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
if ($user['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
$stmt->close();

// Fetch total products
$resProducts = $conn->query("SELECT COUNT(*) as total FROM products");
$totalProducts = $resProducts->fetch_assoc()['total'];

// Fetch total users
$resUsers = $conn->query("SELECT COUNT(*) as total FROM users");
$totalUsers = $resUsers->fetch_assoc()['total'];

// Fetch total orders
$resOrders = $conn->query("SELECT COUNT(*) as total FROM orders");
$totalOrders = $resOrders->fetch_assoc()['total'];

// Fetch completed orders
$resCompleted = $conn->query("SELECT COUNT(*) as total FROM orders WHERE status='Completed'");
$totalCompleted = $resCompleted->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="ad.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="dashboard">
    <h2>Admin Dashboard</h2>

    <div class="section">
        <h3><i class="fa-solid fa-chart-simple"></i> Dashboard Analytics</h3>
        <div class="charts">
            <div class="chart-card">
                <h4>Stock Movement Trend</h4>
                <canvas id="stockChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>User Activity</h4>
                <canvas id="userActivityChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>Monthly Inventory Usage</h4>
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-boxes-stacked"></i> Inventory Management</h3>
        <div class="actions">
            <button class="icon-btn" onclick="navigateTo('mano.php')"><i class="fa-solid fa-list"></i><span>Manage Products</span></button>
            <button class="icon-btn" onclick="navigateTo('add.php')"><i class="fa-solid fa-plus"></i><span>Add Product</span></button>
            <button class="icon-btn" onclick="navigateTo('up.php')"><i class="fa-solid fa-warehouse"></i><span>Update Stock</span></button>
            <button class="icon-btn" onclick="navigateTo('inr.php')"><i class="fa-solid fa-chart-line"></i><span>Inventory Report</span></button>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-cart-shopping"></i> Order Management</h3>
        <div class="actions">
            <button class="icon-btn" onclick="navigateTo('all.php')"><i class="fa-solid fa-receipt"></i><span>All Orders</span></button>
            <button class="icon-btn" onclick="navigateTo('apen.php')"><i class="fa-solid fa-clock"></i><span>Pending</span></button>
            <button class="icon-btn" onclick="navigateTo('acom.php')"><i class="fa-solid fa-check"></i><span>Completed</span></button>
            <button class="icon-btn" onclick="navigateTo('acan.php')"><i class="fa-solid fa-xmark"></i><span>Cancelled</span></button>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-users-gear"></i> User Management</h3>
        <div class="actions">
            <button class="icon-btn" onclick="navigateTo('aman.php')"><i class="fa-solid fa-users"></i><span>Manage Users</span></button>
            <button class="icon-btn" onclick="navigateTo('adu.php')"><i class="fa-solid fa-user-plus"></i><span>Add User</span></button>

    </div>

    <div class="section">
        <h3><i class="fa-solid fa-gear"></i> System Settings</h3>
        <div class="actions">
            <button class="icon-btn" onclick="navigateTo('acp.php')"><i class="fa-solid fa-key"></i><span>Change Password</span></button>
            <button class="icon-btn" onclick="navigateTo('sc.php')"><i class="fa-solid fa-calendar-days"></i><span>Shift Config</span></button>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-toolbox"></i> Admin Utilities</h3>
        <div class="actions">
            <button class="icon-btn refresh" onclick="refreshDashboard()"><i class="fa-solid fa-rotate"></i><span>Refresh</span></button>
            <button class="icon-btn logout" onclick="logoutAdmin()"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button>
        </div>
    </div>
</div>

<script src="ad.js"></script>
</body>
</html>