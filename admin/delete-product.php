<?php
require_once '../includes/db.php';

$id = (int)$_GET['id'];

$product = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();

if ($product && $product['image']) {
    @unlink("../uploads/products/" . $product['image']);
}

$conn->query("DELETE FROM products WHERE id=$id");

header("Location: products.php");
exit;
