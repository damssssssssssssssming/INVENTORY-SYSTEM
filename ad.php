<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
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

$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Orders By Hour (for selected date)
$hourLabels = [];
$hourData = [];
$q3 = $conn->query("SELECT HOUR(created_at) as h, COUNT(*) as total FROM orders WHERE DATE(created_at)='$selectedDate' GROUP BY h ORDER BY h");
while ($row = $q3->fetch_assoc()) {
    $hourLabels[] = $row['h'] . ":00";
    $hourData[] = (int)$row['total'];
}

// Inventory Value (total quantity * price) per day for last 7 days
$invLabels = [];
$invData = [];
$q4 = $conn->query("
    SELECT DATE(created_at) as d, SUM(quantity * price) as total_value
    FROM products
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY d
    ORDER BY d ASC
");
while ($row = $q4->fetch_assoc()) {
    $invLabels[] = $row['d'];
    $invData[] = (float)$row['total_value'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Dashboard</title>
<link rel="stylesheet" href="ad.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<div class="dashboard">
    <h2>Admin Dashboard</h2>

    <div class="date-filter">
        <form method="GET" action="">
            <input type="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" />
            <button type="submit">Filter</button>
        </form>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-chart-simple"></i> Dashboard Analytics</h3>
        <div class="charts">
            <div class="chart-card">
                <h4>Orders By Hour (<?php echo date('M d, Y', strtotime($selectedDate)); ?>)</h4>
                <canvas id="ordersByHourChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>Inventory Value (Last 7 Days)</h4>
                <canvas id="inventoryValueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Rest of your sections unchanged -->
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
        </div>
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

<script>
let hourLabels = <?php echo json_encode($hourLabels); ?>;
let hourData = <?php echo json_encode($hourData); ?>;
let invLabels = <?php echo json_encode($invLabels); ?>;
let invData = <?php echo json_encode($invData); ?>;
</script>

<script src="ad.js"></script>

</body>
</html>