<?php
session_start();
include "config.php";

// Check login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check admin
$stmt = $conn->prepare("SELECT role FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
if ($user['role'] !== 'admin') {
    header("Location: ad.php");
    exit();
}
$stmt->close();

// Handle Delete Product
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: mano.php");
    exit();
}

// Fetch all products
$products = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products</title>
<link rel="stylesheet" href="man.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Manage Products</h1>
        <button class="back-btn" onclick="window.location='ad.php'">← Back to Dashboard</button>
    </div>

    <div class="table-card">
        <table class="products-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price (₱)</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= number_format($row['price'], 2); ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td>
                        <!-- Delete only -->
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-red" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>