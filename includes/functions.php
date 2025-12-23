<?php

/**
 * Skylux Electronics - Global Functions
 * Author: Dantech Developers
 * Year: 2025
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   SECURITY HELPERS
========================= */

/**
 * Escape output safely
 */
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect helper
 */
function redirect($url)
{
    header("Location: $url");
    exit;
}

/* =========================
   PRODUCT HELPERS
========================= */

/**
 * Fetch single product by ID
 */
function getProductById($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * Fetch all products
 */
function getAllProducts($conn)
{
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

/**
 * Check product stock
 */
function isInStock($product)
{
    return isset($product['stock']) && $product['stock'] > 0;
}

/* =========================
   CART FUNCTIONS
========================= */

/**
 * Initialize cart
 */
function initCart()
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

/**
 * Add item to cart
 */
function addToCart($product_id, $qty = 1)
{
    initCart();

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $qty;
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }
}

/**
 * Update cart item quantity
 */
function updateCart($product_id, $qty)
{
    initCart();

    if ($qty <= 0) {
        unset($_SESSION['cart'][$product_id]);
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }
}

/**
 * Remove item from cart
 */
function removeFromCart($product_id)
{
    initCart();
    unset($_SESSION['cart'][$product_id]);
}

/**
 * Clear entire cart
 */
function clearCart()
{
    $_SESSION['cart'] = [];
}

/**
 * Get cart item count
 */
function cartCount()
{
    initCart();
    return array_sum($_SESSION['cart']);
}

/**
 * Get cart total amount
 */
function cartTotal($conn)
{
    initCart();
    $total = 0;

    foreach ($_SESSION['cart'] as $id => $qty) {
        $product = getProductById($conn, $id);
        if ($product) {
            $total += $product['price'] * $qty;
        }
    }

    return $total;
}

/* =========================
   FORMAT HELPERS
========================= */

/**
 * Format price in KES
 */
function formatPrice($amount)
{
    return "Ksh " . number_format($amount, 2);
}

/**
 * Display stock label
 */
function stockLabel($stock)
{
    if ($stock > 0) {
        return "<span class='text-success'>In Stock</span>";
    }
    return "<span class='text-danger'>Out of Stock</span>";
}

/* =========================
   FLASH MESSAGES
========================= */

/**
 * Set flash message
 */
function setFlash($key, $message)
{
    $_SESSION['flash'][$key] = $message;
}

/**
 * Display flash message
 */
function flash($key, $class = 'success')
{
    if (isset($_SESSION['flash'][$key])) {
        echo "<div class='alert alert-$class alert-dismissible fade show' role='alert'>"
            . e($_SESSION['flash'][$key]) .
            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION['flash'][$key]);
    }
}
