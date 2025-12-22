<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit;
}

include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target = "../uploads/products/" . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Insert product into DB
            $sql = "INSERT INTO products (category_id, name, description, price, stock, image) 
                    VALUES ('$category_id', '$name', '$description', '$price', '$stock', '$filename')";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../admin/manage-products.php?success=Product added successfully");
            } else {
                echo "Database error: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Please upload an image.";
    }
}
