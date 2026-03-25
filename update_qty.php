<?php
include "config.php";

if (isset($_GET['id']) && isset($_GET['action'])) {

    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === "plus") {
        $conn->query("UPDATE products SET quantity = quantity + 1 WHERE id = $id");
    }

    if ($action === "minus") {
        $conn->query("UPDATE products 
                      SET quantity = quantity - 1 
                      WHERE id = $id AND quantity > 0");
    }
}

header("Location: mano.php");
exit();
?>