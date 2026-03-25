<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['export']) && $_GET['export'] === 'csv') {

    $products = $conn->query("SELECT * FROM products ORDER BY name ASC");

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="inventory_report.csv"');

    $output = fopen('php://output', 'w');

    fputcsv($output, ['Product Name', 'Quantity', 'Stock Status']);

    while ($row = $products->fetch_assoc()) {
        $status = $row['quantity'] > 5 ? 'Available' : 
                 ($row['quantity'] > 0 ? 'Low' : 'Out of Stock');

        fputcsv($output, [
            $row['name'], 
            $row['quantity'], 
            $status
        ]);
    }

    fclose($output);
    exit();
}

// Fetch products for table display
$products = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Inventory Report</title>
<link rel="stylesheet" href="inr.css">
</head>
<body>

<div class="page-container">
    <div class="page-header">
        <h1>Inventory Report</h1>
        <button class="back-btn" onclick="window.location='ad.php'">← Back to Dashboard</button>
    </div>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search products..." onkeyup="filterTable()"/>
    </div>

    <div class="table-card">
        <table class="report-table" id="reportTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Stock Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $products->fetch_assoc()): 
                    $status = $row['quantity'] > 5 ? 'Available' : 
                             ($row['quantity'] > 0 ? 'Low' : 'Out of Stock');
                    $statusClass = strtolower(str_replace(' ', '', $status));
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td class="status <?= $statusClass; ?>">
                        <?= $status; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="button-group">
        <a href="inr.php?export=csv" class="btn export">Export CSV</a>
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('reportTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const productName = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        rows[i].style.display = productName.includes(input) ? '' : 'none';
    }
}
</script>

</body>
</html>