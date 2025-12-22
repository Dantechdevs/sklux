<?php
include "includes/db.php";
include "includes/header.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">Latest Products</h2>
    <div class="row">
        <?php
        $products = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
        if(mysqli_num_rows($products) > 0):
            while($prod = mysqli_fetch_assoc($products)):
        ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <?php if($prod['image'] && file_exists("uploads/products/".$prod['image'])): ?>
                <img src="uploads/products/<?= $prod['image'] ?>" class="card-img-top"
                    alt="<?= htmlspecialchars($prod['name']) ?>">
                <?php else: ?>
                <img src="images/no-image.png" class="card-img-top" alt="No Image">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($prod['name']) ?></h5>
                    <p class="card-text">Ksh <?= number_format($prod['price'], 2) ?></p>
                    <?php if($prod['stock'] > 0): ?>
                    <a href="cart.php?add=<?= $prod['id'] ?>" class="btn btn-primary mt-auto">Add to Cart</a>
                    <?php else: ?>
                    <span class="text-danger">Out of Stock</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
            endwhile;
        else:
            echo "<p>No products available at the moment.</p>";
        endif;
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>