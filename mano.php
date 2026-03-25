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
    header("Location: ad.php");
    exit();
}
$stmt->close();

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: mano.php");
    exit();
}

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
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>

                    <td>
                        <div class="stepper">
                            <form action="update_qty.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <input type="hidden" name="action" value="minus">
                                <button type="submit">−</button>
                            </form>

                            <input type="text" value="<?= $row['quantity']; ?>" readonly>

                            <form action="update_qty.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <input type="hidden" name="action" value="plus">
                                <button type="submit">+</button>
                            </form>
                        </div>
                    </td>

                    <td>
                        <a href="?delete=<?= $row['id']; ?>" 
                           class="btn btn-red" 
                           onclick="return confirm('Delete this product?')">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>