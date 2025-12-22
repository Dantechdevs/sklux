<?php
include "includes/db.php";
include "includes/header.php";

// Optional: Filter by category
$category_filter = "";
if(isset($_GET['category_id']) && is_numeric($_GET['category_id'])){
    $category_filter = "WHERE category_id=".$_GET['category_id'];
}

// Fetch categories for filter
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
?>

<div class="container mt-5">
    <h2 class="mb-4">Shop</h2>

    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <select name="category_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= (isset($_GET['category_id']) && $_GET['category_id']==$cat['id'])?'selected':'' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
                <?php endwhile; ?>
            </select>
            <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
        </form>
    </div>

    <div class="row">
        <?php
        $products = mysqli_query($conn, "SELECT * FROM products $category_filter ORDER BY created_at DESC");
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
            echo "<p>No products found.</p>";
        endif;
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>