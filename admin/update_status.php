<?php
require_once "../includes/db.php";

// Check if POST data exists
if (!isset($_POST['id'], $_POST['status'])) {
    die("Invalid request");
}

$id = (int)$_POST['id']; // sanitize ID
$status = $_POST['status'];

// Allow only valid statuses
$allowed_statuses = ['Pending', 'Paid', 'Shipped'];
if (!in_array($status, $allowed_statuses)) {
    die("Invalid status");
}

// Update the order status in DB
$conn->query("UPDATE orders SET status='$status' WHERE id=$id");

// Fetch customer email
$order = $conn->query("SELECT email FROM orders WHERE id=$id")->fetch_assoc();

if ($order && filter_var($order['email'], FILTER_VALIDATE_EMAIL)) {
    // Send email notification
    mail(
        $order['email'],
        "Order Update - Skylux",
        "Your order #$id status is now: $status"
    );
}

// Redirect back to orders page
header("Location: orders.php");
exit;
