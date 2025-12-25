<?php
// admin/includes/header.php
$currentPage = basename($_SERVER['PHP_SELF']);
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
        :root {
            --nav-height: 56px;
            --sidebar-width: 220px;
            --sidebar-collapsed-width: 60px;
        }

        body {
            overflow-x: hidden;
        }

        /* Top Navbar */
        .navbar {
            height: var(--nav-height);
            z-index: 1100;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--nav-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background-color: #2c343a;
            color: #fff;
            overflow-y: auto;
            transition: width 0.3s ease, transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar h4 {
            padding: 15px 0;
            margin: 0;
            font-size: 18px;
            border-bottom: 1px solid #3d464d;
            text-align: center;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #ddd;
            text-decoration: none;
            font-size: 15px;
            transition: background 0.2s, padding 0.3s;
        }

        .sidebar.collapsed a {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .sidebar.collapsed h4,
        .sidebar.collapsed a span {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            padding-top: calc(var(--nav-height) + 20px);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .sidebar.collapsed~.main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Scroll-to-top button */
        #scrollTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1200;
            display: none;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        #scrollTopBtn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                top: 0;
                height: 100vh;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-light d-md-none me-2" id="sidebarToggleMobile">☰</button>

            <button class="btn btn-outline-light d-none d-md-inline me-2" id="sidebarToggleDesktop">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="index.php">Skylux Admin</a>

            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h4>Admin Panel</h4>

        <a href="index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">
            <i class="fas fa-home"></i><span>Dashboard</span>
        </a>

        <a href="products.php" class="<?= $currentPage == 'products.php' ? 'active' : '' ?>">
            <i class="fas fa-box"></i><span>Products</span>
        </a>

        <a href="orders.php" class="<?= $currentPage == 'orders.php' ? 'active' : '' ?>">
            <i class="fas fa-shopping-cart"></i><span>Orders</span>
        </a>

        <a href="users.php" class="<?= $currentPage == 'users.php' ? 'active' : '' ?>">
            <i class="fas fa-users"></i><span>Users</span>
        </a>

        <a href="settings.php" class="<?= $currentPage == 'settings.php' ? 'active' : '' ?>">
            <i class="fas fa-cog"></i><span>Settings</span>
        </a>

        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </a>
    </div>

    <!-- SCROLL TO TOP -->
    <button id="scrollTopBtn"><i class="fas fa-chevron-up"></i></button>

    <!-- MAIN CONTENT START -->
    <div class="main-content">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const scrollBtn = document.getElementById('scrollTopBtn');

                document.getElementById('sidebarToggleMobile').onclick = () => {
                    sidebar.classList.toggle('show');
                };

                document.getElementById('sidebarToggleDesktop').onclick = () => {
                    sidebar.classList.toggle('collapsed');
                };

                window.addEventListener('scroll', () => {
                    scrollBtn.style.display = window.scrollY > 100 ? 'block' : 'none';
                });

                scrollBtn.onclick = () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                };
            });
        </script>