<?php
require_once "includes/db.php";
require_once "includes/functions.php";
include "includes/header.php";

/* =========================
   HANDLE ADD TO CART
========================= */
if (isset($_GET['add'])) {
    addToCart((int)$_GET['add']);
    setFlash('cart', '✅ Product added to cart successfully!');
    redirect('shop.php');
}

/* =========================
   FETCH ALL PRODUCTS
========================= */
$products = getAllProducts($conn);
?>

<div class="container my-5">
    <h2 class="mb-4">🛍️ Our Products</h2>

    <?php flash('cart'); ?>

    <?php if (!empty($products)): ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($product['image'])): ?>
                            <img src="assets/images/<?= e($product['image']); ?>" class="card-img-top"
                                alt="<?= e($product['name']); ?>">
                        <?php else: ?>
                            <img src="assets/images/placeholder.png" class="card-img-top" alt="<?= e($product['name']); ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= e($product['name']); ?></h5>
                            <p class="card-text text-primary fw-bold"><?= formatPrice($product['price']); ?></p>
                            <a href="shop.php?add=<?= $product['id']; ?>" class="btn btn-success mt-auto">
                                ➕ Add to Cart
                            </a>
                        </div>
                        <div class="card-footer text-center">
                            <?= stockLabel($product['stock']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            No products available at the moment.
        </div>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>