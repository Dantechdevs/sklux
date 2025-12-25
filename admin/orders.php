<?php
require_once "../includes/db.php";
require_once "../includes/functions.php"; // ← Needed for formatPrice() and e()
include "includes/header.php";

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="main-content">
    <h2>📦 Orders</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= e($o['id']); ?></td>
                        <td><?= e($o['name']); ?></td>
                        <td><?= formatPrice($o['total']); ?></td>
                        <td>
                            <form method="post" action="update_status.php">
                                <input type="hidden" name="id" value="<?= e($o['id']); ?>">
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                    <option value="Pending" <?= $o['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Paid" <?= $o['status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="Shipped" <?= $o['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="view_order.php?id=<?= e($o['id']); ?>" class="btn btn-sm btn-info">View</a>
                            <a href="print_invoice.php?id=<?= e($o['id']); ?>" class="btn btn-sm btn-dark">Print</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "includes/footer.php"; ?>