<?php
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: shop.php');
    exit();
}

$id = sanitize($_GET['id'], $conn);
$sql = "SELECT * FROM products WHERE id='$id'";
$result = $conn->query($sql);

if($result->num_rows == 0) {
    echo '<div class="container mt-5"><p>Product not found.</p></div>';
    include 'includes/footer.php';
    exit();
}

$product = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="uploads/products/<?php echo $product['image']; ?>" class="img-fluid"
                alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-6">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <p class="fw-bold">KES <?php echo number_format($product['price'],2); ?></p>

            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width:100px;">
                </div>
                <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>