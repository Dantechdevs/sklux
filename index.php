<?php
require_once "includes/db.php";
require_once "includes/functions.php";
include "includes/header.php";

/* =========================
   FETCH FEATURED PRODUCTS (LATEST 6)
========================= */
$products = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 6")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1>Welcome to Skylux Electronics</h1>
        <p class="lead">🛍️ Quality electronics at great prices</p>
        <a href="shop.php" class="btn btn-primary btn-lg">View All Products</a>
        <a href="cart.php" class="btn btn-success btn-lg ms-2">🛒 View Cart</a>
    </div>

    <h2 class="mb-4">Featured Products</h2>

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