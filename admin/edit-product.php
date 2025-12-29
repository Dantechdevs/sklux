<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";

/* =========================
   FETCH PRODUCT
========================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$productStmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$productStmt->bind_param("i", $id);
$productStmt->execute();
$product = $productStmt->get_result()->fetch_assoc();

if (!$product) {
    redirect("products.php");
}

/* =========================
   HANDLE UPDATE (BEFORE HTML)
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];

    // Default: keep old image
    $imageName = $product['image'];

    // Upload directory (absolute path)
    $uploadDir = __DIR__ . '/../uploads/products/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {

        // Delete old image (optional but clean)
        if (!empty($product['image']) && file_exists($uploadDir . $product['image'])) {
            unlink($uploadDir . $product['image']);
        }

        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
    }

    $stmt = $conn->prepare(
        "UPDATE products SET name=?, price=?, stock=?, image=? WHERE id=?"
    );
    $stmt->bind_param("sdisi", $name, $price, $stock, $imageName, $id);
    $stmt->execute();

    redirect("products.php");
}

/* =========================
   HTML STARTS HERE
========================= */
include "includes/header.php";
?>

<div class="container-fluid">
    <h2 class="mb-4">✏️ Edit Product</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm w-100">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?= e($product['name']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" value="<?= $product['stock']; ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label><br>

            <!-- CURRENT IMAGE -->
            <?php if (!empty($product['image'])): ?>
                <img id="imagePreview" src="../uploads/products/<?= e($product['image']); ?>" class="mb-2 rounded"
                    width="80">
            <?php else: ?>
                <img id="imagePreview" src="../assets/images/placeholder.png" class="mb-2 rounded" width="80">
            <?php endif; ?>

            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
        </div>

        <div class="mt-3">
            <button class="btn btn-warning">Update Product</button>
            <a href="products.php" class="btn btn-secondary ms-2">Back</a>
        </div>
    </form>
</div>

<!-- IMAGE PREVIEW SCRIPT -->
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php include "includes/footer.php"; ?>