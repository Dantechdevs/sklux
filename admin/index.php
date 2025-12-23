<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";
include "includes/header.php";

// Fetch stats
$totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetch_row()[0];
$totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
$totalRevenue = $conn->query("SELECT SUM(price*quantity) FROM orders")->fetch_row()[0];

// Fetch recent products and orders
$recentProducts = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
$recentOrders = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
?>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-center py-3">Admin Panel</h4>
    <a href="index.php" class="active">Dashboard</a>
    <a href="products.php">Products</a>
    <a href="orders.php">Orders</a>
    <a href="users.php">Users</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" style="margin-left:220px; padding:20px;">
    <h1 class="mb-4">🏠 Dashboard</h1>

    <!-- Dashboard Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card text-center shadow-sm p-3">
                <h5>Total Products</h5>
                <p class="fs-3"><?= $totalProducts; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm p-3">
                <h5>Total Orders</h5>
                <p class="fs-3"><?= $totalOrders; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm p-3">
                <h5>Total Revenue</h5>
                <p class="fs-3"><?= formatPrice($totalRevenue); ?></p>
            </div>
        </div>
    </div>

    <!-- Recent Products Table -->
    <h3 class="mb-3">📦 Recent Products</h3>
    <table class="table table-bordered table-hover shadow-sm mb-5">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentProducts as $prod): ?>
            <tr>
                <td><?= e($prod['id']); ?></td>
                <td><?= e($prod['name']); ?></td>
                <td><?= formatPrice($prod['price']); ?></td>
                <td><?= $prod['stock']; ?></td>
                <td>
                    <a href="products.php?edit=<?= $prod['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="products.php?delete=<?= $prod['id']; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Recent Orders Table -->
    <h3 class="mb-3">🛒 Recent Orders</h3>
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td><?= e($order['order_id']); ?></td>
                <td><?= e($order['product_id']); ?></td>
                <td><?= e($order['quantity']); ?></td>
                <td><?= formatPrice($order['price']); ?></td>
                <td><?= $order['status'] ?? 'Pending'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include "includes/footer.php"; ?>