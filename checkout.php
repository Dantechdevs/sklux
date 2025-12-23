<?php
require_once "includes/db.php";
require_once "includes/functions.php";
include "includes/header.php";

/* =========================
   REDIRECT IF CART EMPTY
========================= */
if (empty($_SESSION['cart'])) {
    setFlash('cart', 'Your cart is empty, please add items first.');
    redirect('cart.php');
}

/* =========================
   HANDLE ORDER SUBMISSION
========================= */
if (isset($_POST['place_order'])) {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Simple validation
    if (!$name || !$email || !$phone || !$address) {
        setFlash('checkout', 'All fields are required.');
        redirect('checkout.php');
    }

    // Calculate total
    $total = cartTotal($conn);

    // Insert into orders
    $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, address, total, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssd", $name, $email, $phone, $address, $total);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert order items
        foreach ($_SESSION['cart'] as $id => $qty) {
            $product = getProductById($conn, $id);
            if (!$product) continue;

            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt_item->bind_param("iiid", $order_id, $id, $qty, $product['price']);
            $stmt_item->execute();
        }

        // Clear cart
        unset($_SESSION['cart']);

        setFlash('checkout_success', "✅ Order placed successfully! Your Order ID is #{$order_id}");
        redirect('checkout.php');
    } else {
        setFlash('checkout', 'Error placing order. Please try again.');
        redirect('checkout.php');
    }
}
?>

<div class="container my-5">
    <h2 class="mb-4">🛒 Checkout</h2>

    <?php flash('checkout'); ?>
    <?php flash('checkout_success'); ?>

    <div class="row">
        <div class="col-md-6">
            <h4>Shipping Details</h4>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" name="place_order" class="btn btn-success">
                    ✅ Place Order
                </button>
            </form>
        </div>

        <div class="col-md-6">
            <h4>Order Summary</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $id => $qty):
                        $product = getProductById($conn, $id);
                        if (!$product) continue;
                        $subtotal = $product['price'] * $qty;
                    ?>
                        <tr>
                            <td><?= e($product['name']); ?></td>
                            <td><?= $qty; ?></td>
                            <td><?= formatPrice($subtotal); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h5 class="text-end">
                Total: <span class="text-primary"><?= formatPrice(cartTotal($conn)); ?></span>
            </h5>
        </div>
    </div>

    <div class="mt-4">
        <a href="cart.php" class="btn btn-secondary">← Back to Cart</a>
    </div>
</div>

<?php include "includes/footer.php"; ?>