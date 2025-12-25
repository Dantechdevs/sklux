<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";
include "includes/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid order ID");
}

$orderId = (int) $_GET['id'];

/* ===== FETCH ORDER INFO ===== */
$order = $conn->query("
    SELECT * FROM orders WHERE id = $orderId
")->fetch_assoc();

if (!$order) {
    die("Order not found");
}

/* ===== FETCH ORDER ITEMS ===== */
$orderItems = $conn->query("
    SELECT 
        p.name,
        oi.quantity,
        oi.price,
        (oi.quantity * oi.price) AS subtotal
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = $orderId
")->fetch_all(MYSQLI_ASSOC);
?>

<div class="main-content">
    <h1 class="mb-4">🧾 Order #<?= e($order['id']); ?></h1>

    <!-- Order Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Customer:</strong> <?= e($order['name']); ?></p>
            <p><strong>Email:</strong> <?= e($order['email']); ?></p>
            <p><strong>Phone:</strong> <?= e($order['phone']); ?></p>
            <p><strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
            <p><strong>Total:</strong> <?= formatPrice($order['total']); ?></p>
        </div>
    </div>

    <!-- Order Items -->
    <h4 class="mb-3">🛒 Products</h4>
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?= e($item['name']); ?></td>
                    <td><?= formatPrice($item['price']); ?></td>
                    <td><?= e($item['quantity']); ?></td>
                    <td><?= formatPrice($item['subtotal']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="orders.php" class="btn btn-secondary mt-3">⬅ Back to Orders</a>
</div>

<?php include "includes/footer.php"; ?>