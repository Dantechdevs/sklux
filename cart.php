<?php
session_start();
include "includes/db.php";
include "includes/header.php";

// Add product to cart
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $qty = 1;
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    header("Location: cart.php");
    exit;
}

// Remove product
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}

// Clear cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// Update quantity via AJAX
if (isset($_POST['update_cart'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    if ($qty > 0) {
        $_SESSION['cart'][$id] = $qty;
    } else {
        unset($_SESSION['cart'][$id]);
    }
    echo "success";
    exit;
}
?>

<div class="container mt-5">
    <h2>Your Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered mt-3 align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price (Ksh)</th>
                    <th>Quantity</th>
                    <th>Subtotal (Ksh)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $prod_id => $qty):
                    $res = mysqli_query($conn, "SELECT * FROM products WHERE id='$prod_id'");
                    $prod = mysqli_fetch_assoc($res);
                    $subtotal = $prod['price'] * $qty;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td>
                            <?php if ($prod['image'] && file_exists("uploads/products/" . $prod['image'])): ?>
                                <img src="uploads/products/<?= $prod['image'] ?>" width="50" class="me-2">
                            <?php endif; ?>
                            <?= htmlspecialchars($prod['name']) ?>
                        </td>
                        <td><?= number_format($prod['price'], 2) ?></td>
                        <td>
                            <input type="number" class="form-control qty" data-id="<?= $prod['id'] ?>" value="<?= $qty ?>"
                                min="1" style="width:70px;">
                        </td>
                        <td class="subtotal" data-id="<?= $prod['id'] ?>"><?= number_format($subtotal, 2) ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $prod['id'] ?>" class="btn btn-sm btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2" id="cart-total"><strong>Ksh <?= number_format($total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <a href="cart.php?clear" class="btn btn-warning mb-4">Clear Cart</a>

        <h4>Checkout via WhatsApp</h4>
        <form method="POST" action="cart.php#checkout">
            <div class="mb-3">
                <input type="text" name="customer_name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="mb-3">
                <input type="text" name="location" class="form-control" placeholder="Delivery Location" required>
            </div>
            <button type="submit" name="checkout" class="btn btn-success">Send Order via WhatsApp</button>
        </form>

        <?php
        // Handle WhatsApp checkout
        if (isset($_POST['checkout'])) {
            $name = urlencode($_POST['customer_name']);
            $phone = urlencode($_POST['phone']);
            $location = urlencode($_POST['location']);

            $message = "Hello Skylux, I would like to place an order:%0A";
            foreach ($_SESSION['cart'] as $prod_id => $qty) {
                $res = mysqli_query($conn, "SELECT * FROM products WHERE id='$prod_id'");
                $prod = mysqli_fetch_assoc($res);
                $message .= "- " . $prod['name'] . " x" . $qty . " (Ksh " . number_format($prod['price'], 2) . ")%0A";
            }
            $message .= "Total: Ksh " . number_format($total, 2) . "%0A";
            $message .= "Name: $name%0APhone: $phone%0ALocation: $location";

            $whatsapp_number = "254769069686"; // Replace with your number
            $url = "https://wa.me/$whatsapp_number?text=$message";

            // Save order in DB
            $order_sql = "INSERT INTO orders (customer_name, phone, location, total) 
                          VALUES ('$name','$phone','$location','$total')";
            mysqli_query($conn, $order_sql);
            $order_id = mysqli_insert_id($conn);

            foreach ($_SESSION['cart'] as $prod_id => $qty) {
                $res = mysqli_query($conn, "SELECT * FROM products WHERE id='$prod_id'");
                $prod = mysqli_fetch_assoc($res);
                mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                     VALUES ('$order_id', '$prod_id', '$qty', '" . $prod['price'] . "')");
            }

            // Clear cart after checkout
            unset($_SESSION['cart']);

            // Redirect to WhatsApp
            echo "<script>window.open('$url','_blank'); window.location='shop.php';</script>";
        }
        ?>

    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="shop.php" class="btn btn-primary">Go to Shop</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".qty").on("change", function() {
            let id = $(this).data("id");
            let qty = $(this).val();

            $.post("cart.php", {
                update_cart: 1,
                id: id,
                qty: qty
            }, function(response) {
                if (response == "success") {
                    location.reload(); // Reload to update subtotal & total
                }
            });
        });
    });
</script>

<?php include "includes/footer.php"; ?>