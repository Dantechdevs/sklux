<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";
include "includes/header.php";

/* ================= DASHBOARD STATS ================= */
$totalProducts = $conn->query("SELECT COUNT(*) AS total FROM products")
    ->fetch_assoc()['total'] ?? 0;

$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")
    ->fetch_assoc()['total'] ?? 0;

$totalRevenue = $conn->query("SELECT SUM(total) AS revenue FROM orders")
    ->fetch_assoc()['revenue'] ?? 0;

/* ================= RECENT PRODUCTS ================= */
$recentProducts = $conn->query("
    SELECT id, name, price, stock
    FROM products
    ORDER BY id DESC
    LIMIT 5
")->fetch_all(MYSQLI_ASSOC);

/* ================= RECENT ORDERS ================= */
$recentOrders = $conn->query("
    SELECT 
        o.id AS order_id,
        o.name AS customer,
        o.total,
        o.status,
        o.created_at,
        GROUP_CONCAT(p.name SEPARATOR ', ') AS products,
        SUM(oi.quantity) AS total_qty
    FROM orders o
    JOIN order_items oi ON oi.order_id = o.id
    JOIN products p ON p.id = oi.product_id
    GROUP BY o.id
    ORDER BY o.id DESC
    LIMIT 5
")->fetch_all(MYSQLI_ASSOC);

/* ================= MONTHLY SALES ================= */
$monthlySales = array_fill(1, 12, 0);

$salesQuery = $conn->query("
    SELECT MONTH(created_at) AS month, SUM(total) AS revenue
    FROM orders
    WHERE YEAR(created_at) = YEAR(CURDATE())
    GROUP BY MONTH(created_at)
");

while ($row = $salesQuery->fetch_assoc()) {
    $monthlySales[(int)$row['month']] = (float)$row['revenue'];
}
?>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content">

    <h1 class="mb-4">🏠 Dashboard</h1>

    <!-- DASHBOARD CARDS -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card text-center shadow-sm p-3">
                <h6>Total Products</h6>
                <p class="fs-3 fw-bold"><?= $totalProducts; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm p-3">
                <h6>Total Orders</h6>
                <p class="fs-3 fw-bold"><?= $totalOrders; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm p-3">
                <h6>Total Revenue</h6>
                <p class="fs-3 fw-bold text-success"><?= formatPrice($totalRevenue); ?></p>
            </div>
        </div>
    </div>

    <!-- SALES CHART -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="mb-3">📈 Monthly Revenue</h5>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    <!-- RECENT PRODUCTS -->
    <h3 class="mb-3">📦 Recent Products</h3>
    <table class="table table-bordered table-hover shadow-sm mb-5">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentProducts): ?>
            <?php foreach ($recentProducts as $prod): ?>
            <tr>
                <td><?= e($prod['id']); ?></td>
                <td><?= e($prod['name']); ?></td>
                <td><?= formatPrice($prod['price']); ?></td>
                <td>
                    <span class="badge bg-<?= $prod['stock'] > 0 ? 'success' : 'danger'; ?>">
                        <?= e($prod['stock']); ?>
                    </span>
                </td>
                <td>
                    <a href="products.php?edit=<?= $prod['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="products.php?delete=<?= $prod['id']; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this product?');">
                        Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted">No products found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- RECENT ORDERS -->
    <h3 class="mb-3">🛒 Recent Orders</h3>
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Products</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentOrders): ?>
            <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td><?= e($order['order_id']); ?></td>
                <td><?= e($order['customer']); ?></td>
                <td><?= e($order['products']); ?></td>
                <td><?= e($order['total_qty']); ?></td>
                <td><?= formatPrice($order['total']); ?></td>
                <td>
                    <span class="badge bg-<?=
                        $order['status'] === 'Paid' ? 'success' :
                        ($order['status'] === 'Shipped' ? 'primary' : 'warning');
                    ?>">
                        <?= e($order['status']); ?>
                    </span>
                </td>
                <td><?= date('d M Y', strtotime($order['created_at'])); ?></td>
                <td>
                    <a href="view_order.php?id=<?= $order['order_id']; ?>" class="btn btn-sm btn-outline-primary">
                        View
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="8" class="text-center text-muted">No recent orders</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode([
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ]); ?>,
        datasets: [{
            label: 'Monthly Revenue',
            data: <?= json_encode(array_values($monthlySales)); ?>,
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php include "includes/footer.php"; ?>