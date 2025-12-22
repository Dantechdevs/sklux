<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skylux Electronics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .navbar-brand img {
            height: 50px;
            border-radius: 50%;
            /* Oval/circular */
            margin-top: 0;
            /* Aligns top */
        }

        .navbar-brand {
            display: flex;
            align-items: flex-start;
            /* Align image to top */
        }

        .navbar-brand span {
            margin-left: 10px;
            color: #fff;
            font-weight: bold;
            align-self: center;
            /* Vertically center text next to image */
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/skylux.png" alt="Skylux Electronics">
                <span>Skylux Electronics</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/254712328150" class="whatsapp_float" target="_blank">
        <i class="fab fa-whatsapp whatsapp-icon"></i>
    </a>

    <style>
        .whatsapp_float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }

        .whatsapp_float:hover {
            transform: scale(1.1);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>