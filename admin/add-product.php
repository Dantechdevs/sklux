<?php
require_once '../includes/db.php';

/* =====================
   HANDLE FORM SUBMIT
===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/products/" . $imageName
        );
    }

    $stmt = $conn->prepare(
        "INSERT INTO products (name, price, stock, image, created_at)
         VALUES (?, ?, ?, ?, NOW())"
    );
    $stmt->bind_param("sdis", $name, $price, $stock, $imageName);
    $stmt->execute();

    header("Location: products.php");
    exit;
}

/* =====================
   LOAD PAGE VIEW
===================== */
require_once 'includes/header.php';
?>

<div class="container-fluid">
    <h2 class="mb-4">➕ Add Product</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm" style="max-width:600px;">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Save Product</button>
        <a href="products.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>