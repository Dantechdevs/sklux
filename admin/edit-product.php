<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: manage-products.php");
    exit;
}

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='$id'"));
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product - Skylux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #preview {
            max-width: 150px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>

        <form action="../php/edit_product_backend.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select" required>
                    <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"
                    rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Price (Ksh)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                <?php if ($product['image'] && file_exists("../uploads/products/" . $product['image'])): ?>
                    <img id="preview" src="../uploads/products/<?= $product['image'] ?>">
                <?php else: ?>
                    <img id="preview" src="#" style="display:none;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success">Update Product</button>
            <a href="manage-products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>