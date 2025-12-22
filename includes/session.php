<?php
// includes/session.php
session_start();

/**
 * Check if admin is logged in
 * Redirect to login.php if not
 */
function checkAdmin()
{
    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Log in admin session
 *
 * @param string $username
 */
function adminLogin($username)
{
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $username;
}

/**
 * Log out admin session
 */
function adminLogout()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

/**
 * Optional: Check if customer session exists
 */
function checkCustomer()
{
    if (!isset($_SESSION['customer_logged_in'])) {
        header("Location: login.php");
        exit();
    }
}
