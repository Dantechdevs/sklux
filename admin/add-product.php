<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

// Fetch categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product - Skylux</title>
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
        <h2>Add New Product</h2>
        <form action="../php/add_product_backend.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label>Price (Ksh)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" value="0" required>
            </div>
            <div class="mb-3">
                <label>Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)"
                    required>
                <img id="preview" src="#" alt="Image Preview" style="display:none;">
            </div>
            <button type="submit" class="btn btn-success">Add Product</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>