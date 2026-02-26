<?php
session_start();
include "config.php";

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
    header("Location: ad.php");
    exit();
}
$stmt->close();

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $name, $price, $quantity);
    $stmt->execute();
    $stmt->close();

    header("Location: mano.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Product</title>
  <link rel="stylesheet" href="add.css" />
</head>
<body>
  <div class="page-container">
    <div class="page-header">
      <h1>Add Product</h1>
      <button class="back-btn" onclick="window.location='mano.php'">← Back to Dashboard</button>
    </div>

    <form method="POST" autocomplete="off">
      <label for="productName">Product Name</label>
      <input type="text" name="name" id="productName" required />

      <label for="initialStock">Initial Stock</label>
      <input type="number" name="quantity" id="initialStock" min="0" required />

      <label for="price">Price (₱)</label>
      <input type="number" name="price" id="price" min="0" step="0.01" required />

      <div class="buttons">
        <button type="submit" name="add" class="btn submit">Save Product</button>
        <button type="button" class="btn cancel" onclick="window.location='mano.php'">Cancel</button>
      </div>
    </form>
  </div>
</body>
</html>