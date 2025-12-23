<?php
require_once "includes/db.php";
require_once "includes/functions.php";
include "includes/header.php";

/* =========================
   CART ACTIONS
========================= */

// Add to cart
if (isset($_GET['add'])) {
    addToCart((int)$_GET['add'], 1); // Always add 1 item if first added
    setFlash('cart', '✅ Product added to the cart successfully!');
    redirect("cart.php");
}

// Remove item
if (isset($_GET['remove'])) {
    removeFromCart((int)$_GET['remove']);
    setFlash('cart', '❌ Product removed from the cart.');
    redirect("cart.php");
}

// Update quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        updateCart((int)$id, (int)$qty);
    }
    setFlash('cart', '🔄 Cart updated successfully.');
    redirect("cart.php");
}
?>

<div class="container my-5">
    <h2 class="mb-4">🛒 Shopping Cart</h2>

    <!-- Flash Messages -->
    <?php flash('cart'); ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form method="POST">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th width="120">Quantity</th>
                            <th>Subtotal</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $qty):
                            $product = getProductById($conn, $id);
                            if (!$product) continue;
                            $subtotal = $product['price'] * $qty;
                        ?>
                            <tr>
                                <td><strong><?= e($product['name']); ?></strong></td>
                                <td><?= formatPrice($product['price']); ?></td>
                                <td>
                                    <input type="number" name="qty[<?= $id; ?>]" value="<?= $qty; ?>" min="1" class="form-control qty">
                                </td>
                                <td><?= formatPrice($subtotal); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?= $id; ?>" class="btn btn-danger btn-sm">
                                        ✖
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" name="update_cart" class="btn btn-primary">
                    🔄 Update Cart
                </button>
                <h4>Total:
                    <span class="text-primary"><?= formatPrice(cartTotal($conn)); ?></span>
                </h4>
            </div>
        </form>

        <div class="mt-4 text-end">
            <a href="shop.php" class="btn btn-secondary">← Continue Shopping</a>
            <a href="checkout.php" class="btn btn-success ms-2 <?= empty($_SESSION['cart']) ? 'disabled' : '' ?>">
                ✅ Proceed to Checkout
            </a>
        </div>

    <?php else: ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Your cart is empty.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <a href="shop.php" class="btn btn-primary">🛍️ Start Shopping</a>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>