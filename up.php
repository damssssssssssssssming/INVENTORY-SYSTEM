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

// Handle stock update
if (isset($_POST['update'])) {
    $product_id = intval($_POST['product_id']);
    $quantity_change = intval($_POST['quantity_change']);
    $reason = $_POST['reason'];

    // Get current quantity
    $stmt = $conn->prepare("SELECT quantity FROM products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $product = $res->fetch_assoc();
    $stmt->close();

    if ($product) {
        $new_quantity = $product['quantity'] + $quantity_change;
        $stmt = $conn->prepare("UPDATE products SET quantity=? WHERE id=?");
        $stmt->bind_param("ii", $new_quantity, $product_id);
        $stmt->execute();
        $stmt->close();

        // Optionally, log the reason somewhere if you have a stock history table

        header("Location: mano.php");
        exit();
    }
}

// Fetch all products
$products = $conn->query("SELECT id, name, quantity FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Stock</title>
  <link rel="stylesheet" href="up.css">
</head>
<body>
  <div class="page-container">
    <div class="page-header">
      <h1>Update Stock</h1>
      <button class="back-btn" onclick="window.location='mano.php'">← Back to Dashboard</button>
    </div>

    <form method="POST" autocomplete="off">
      <label for="productSelect">Select Product</label>
      <select id="productSelect" name="product_id" required onchange="updateCurrentStock(this)">
        <option value="">-- Select --</option>
        <?php while ($row = $products->fetch_assoc()): ?>
          <option value="<?= $row['id'] ?>" data-qty="<?= $row['quantity'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
      </select>

      <label>Current Stock: <span id="currentStock">0</span></label>

      <label for="quantityChange">Quantity Change</label>
      <input type="number" id="quantityChange" name="quantity_change" required />

      <label for="reason">Reason (optional)</label>
      <input type="text" id="reason" name="reason" placeholder="Stock adjustment reason" />

      <div class="buttons">
        <button type="submit" name="update" class="btn submit">Update Stock</button>
        <button type="button" class="btn cancel" onclick="window.location='mano.php'">Cancel</button>
      </div>
    </form>
  </div>

  <script>
    function updateCurrentStock(select) {
      const option = select.selectedOptions[0];
      document.getElementById('currentStock').textContent = option ? option.getAttribute('data-qty') : 0;
    }
  </script>
</body>
</html>