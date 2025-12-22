<?php
// includes/functions.php

/**
 * Sanitize input data to prevent SQL injection and XSS
 *
 * @param string $data
 * @param mysqli $conn
 * @return string
 */
function sanitize($data, $conn)
{
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

/**
 * Format price with 2 decimal places
 *
 * @param float $price
 * @return string
 */
function formatPrice($price)
{
    return number_format($price, 2);
}

/**
 * Redirect to a given URL
 *
 * @param string $url
 */
function redirect($url)
{
    header("Location: $url");
    exit();
}

/**
 * Debug function (for development)
 *
 * @param mixed $data
 */
function debug($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
