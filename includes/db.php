<?php
// includes/db.php

// Database configuration
$servername = "localhost";   // Usually localhost
$username   = "root";        // Your MySQL username
$password   = "";            // Your MySQL password
$dbname     = "skylux_db";   // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8 for proper encoding
$conn->set_charset("utf8");
