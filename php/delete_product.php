<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit;
}

include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get image name
    $res = mysqli_query($conn, "SELECT image FROM products WHERE id='$id'");
    $row = mysqli_fetch_assoc($res);
    if ($row['image'] && file_exists("../uploads/products/" . $row['image'])) {
        unlink("../uploads/products/" . $row['image']);
    }

    // Delete product
    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

    header("Location: ../admin/manage-products.php?success=Product deleted successfully");
}
