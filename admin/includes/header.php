<?php
// admin/includes/header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skylux Electronics Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Admin CSS -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar h4 {
            color: white;
            padding: 10px 0;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar .active {
            background-color: #007bff;
            color: #fff;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Top navbar height */
        :root {
            --nav-height: 56px;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--nav-height);
            left: 0;
            width: 220px;
            height: calc(100vh - var(--nav-height));
            background-color: #2c343a;
            color: #fff;
            padding-top: 10px;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar h4 {
            color: #fff;
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #ddd;
            text-decoration: none;
            font-size: 15px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0d6efd;
            color: #fff;
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 20px;
            padding-top: calc(var(--nav-height) + 20px);
        }
    </style>
</head>

<body>


    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="products.php"><i class="fas fa-box"></i> Products</a>
        <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>