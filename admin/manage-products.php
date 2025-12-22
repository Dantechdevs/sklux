<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

// Fetch all products with category name
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";
$products = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products - Skylux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Manage Products</h2>

        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <a href="add-product.php" class="btn btn-primary mb-3">Add New Product</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (Ksh)</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($prod = mysqli_fetch_assoc($products)) { ?>
                <tr>
                    <td><?= $prod['id'] ?></td>
                    <td>
                        <?php if($prod['image'] && file_exists("../uploads/products/".$prod['image'])): ?>
                        <img src="../uploads/products/<?= $prod['image'] ?>" width="60" alt="Product Image">
                        <?php else: ?>
                        No Image
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($prod['name']) ?></td>
                    <td><?= htmlspecialchars($prod['category_name']) ?></td>
                    <td><?= number_format($prod['price'], 2) ?></td>
                    <td><?= $prod['stock'] ?></td>
                    <td>
                        <a href="edit-product.php?id=<?= $prod['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="../php/delete_product.php?id=<?= $prod['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>

</html>