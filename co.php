<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$stmtUser = $conn->prepare("SELECT id FROM users WHERE username=?");
$stmtUser->bind_param("s", $_SESSION['username']);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$user = $userResult->fetch_assoc();
$user_id = $user['id'];
$stmtUser->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn->begin_transaction();

    try {

        $hasOrder = false;

        foreach ($_POST['qty'] as $product_id => $quantity) {

            $quantity = intval($quantity);

            if ($quantity > 0) {

                $hasOrder = true;

                $stmt = $conn->prepare("SELECT name, price, quantity FROM products WHERE id=? FOR UPDATE");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();
                $stmt->close();

                if (!$product) {
                    throw new Exception("Product not found.");
                }

                if ($product['quantity'] < $quantity) {
                    throw new Exception("Not enough stock for " . $product['name']);
                }

                $lineTotal = $product['price'] * $quantity;

                $newStock = $product['quantity'] - $quantity;
                $updateStock = $conn->prepare("UPDATE products SET quantity=? WHERE id=?");
                $updateStock->bind_param("ii", $newStock, $product_id);
                $updateStock->execute();
                $updateStock->close();

                $insertOrder = $conn->prepare("
                    INSERT INTO orders (product_id, quantity, status, user_id, total_amount) 
                    VALUES (?, ?, 'Pending', ?, ?)
                ");
                $insertOrder->bind_param("iiid", $product_id, $quantity, $user_id, $lineTotal);
                $insertOrder->execute();
                $insertOrder->close();
            }
        }

        if (!$hasOrder) {
            throw new Exception("Please select at least one product.");
        }

        $conn->commit();

        echo "<script>
                alert('Order submitted successfully!');
                window.location='pending-orders.php';
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Order failed: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Order</title>
    <link rel="stylesheet" href="co.css">
</head>
<body>
<div class="page-container centered-container">
    <h1>Create New Order</h1>

    <form method="POST" class="order-form">

        <div class="table-card">
            <table border="1" cellpadding="10" class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $products = $conn->query("SELECT * FROM products ORDER BY name ASC");
                    while ($row = $products->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>₱<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <div class="qty-control">
                                <button type="button" class="qty-btn minus">−</button>
                                <span class="qty-value">0</span>
                                <button type="button" class="qty-btn plus">+</button>
                            </div>
                            <input type="hidden" name="qty[<?php echo $row['id']; ?>]" value="0" class="hidden-qty">
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-submit">Submit Order</button>
            <button type="button" class="btn btn-cancel" onclick="window.location='dashboard.php'">Back to Dashboard</button>
        </div>

    </form>
</div>

<script>
document.querySelectorAll(".order-table tbody tr").forEach(row => {
    const qtySpan = row.querySelector(".qty-value");
    const hiddenInput = row.querySelector(".hidden-qty");
    let qty = 0;

    row.querySelector(".plus").addEventListener("click", () => {
        const max = parseInt(row.cells[2].textContent);
        if (qty < max) qty++;
        qtySpan.textContent = qty;
        hiddenInput.value = qty;
    });

    row.querySelector(".minus").addEventListener("click", () => {
        if (qty > 0) qty--;
        qtySpan.textContent = qty;
        hiddenInput.value = qty;
    });
});
</script>
</body>
</html>