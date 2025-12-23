<?php
require_once "includes/db.php";

// Create products table if it doesn't exist
$tableSql = "
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if ($conn->query($tableSql) === TRUE) {
    echo "✅ Table 'products' is ready.<br>";
} else {
    die("❌ Error creating table: " . $conn->error);
}

// Sample products to insert
$sampleProducts = [
    ['Smartphone X1', 19999.00, 10, 'smartphone1.jpg'],
    ['Laptop Pro 15"', 54999.00, 5, 'laptop1.jpg'],
    ['Wireless Earbuds', 4999.00, 20, 'earbuds1.jpg'],
    ['Smartwatch S3', 8999.00, 15, 'smartwatch1.jpg'],
    ['Gaming Mouse', 2999.00, 25, 'mouse1.jpg'],
    ['Bluetooth Speaker', 3999.00, 12, 'speaker1.jpg'],
];

// Insert sample products
foreach ($sampleProducts as $p) {
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $p[0], $p[1], $p[2], $p[3]);
    $stmt->execute();
}

echo "✅ Sample products inserted successfully!";
