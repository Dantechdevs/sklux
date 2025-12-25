<?php
require_once "../includes/db.php";

$id = (int)$_GET['id'];

$order = $conn->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();
$items = $conn->query("
    SELECT p.name, oi.quantity, oi.price
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id=$id
")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Invoice #<?= $id ?></title>
    <style>
    body {
        font-family: Arial;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid #000;
        padding: 8px;
    }
    </style>
</head>

<body onload="window.print()">
    <h2>Skylux Electronics</h2>
    <p><strong>Order #<?= $id ?></strong></p>

    <table>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        <?php foreach($items as $i): ?>
        <tr>
            <td><?= $i['name'] ?></td>
            <td><?= $i['quantity'] ?></td>
            <td>Ksh <?= number_format($i['price'],2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Total: Ksh <?= number_format($order['total'],2) ?></h3>
</body>

</html>