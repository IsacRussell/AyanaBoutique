<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayana Boutique</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400&display=swap" rel="stylesheet">
    
    <style>
        /* Luxury CSS & Design Tokens */
        :root {
            --off-white: #FAF6F0;
            --off-white-alt: #F0E8DB;
            --royal-emerald: #0B4F3F;
            --emerald-hover: #146356;
            --emerald-soft: #DCE8E3;
            --rose-gold: #B76E79;
            --rose-gold-deep: #9B5661;
            --rose-gold-soft: #F0DCDD;
            --ink: #2C2620;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--off-white);
            color: var(--ink);
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            line-height: 1.6;
            animation: fadeIn 1.2s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        h1, h2, h3, h4, h5, h6, .brand-title {
            font-family: 'Cinzel', serif;
            font-weight: 400;
            color: var(--royal-emerald);
            letter-spacing: 2px;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color 0.4s ease, border-color 0.4s ease, background-color 0.4s ease;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation Header */
        header {
            padding: 30px 0;
            border-bottom: 1px solid var(--emerald-soft);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--royal-emerald);
        }

        .nav-links a:hover {
            color: var(--rose-gold);
        }

        /* Hero Layout - Full Width Edge-to-Edge */
        .hero-section {
            width: 100vw;
            max-width: 100vw;
            position: relative;
            text-align: center;
            line-height: 0;
            margin-bottom: 60px;
        }
        
        .hero-section img {
            width: 100%;
            height: auto;
            max-height: 85vh;
            object-fit: cover;
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(250, 246, 240, 0.85);
            padding: 40px 60px;
            border: 1px solid var(--rose-gold-soft);
            width: 80%;
            max-width: 800px;
            line-height: 1.6;
        }

        /* Elegant Text-Only Category Blocks */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 40px 0 80px 0;
        }

        .category-item {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            border: 1px solid var(--rose-gold-soft);
            background-color: transparent;
            text-align: center;
        }

        .category-item h3 {
            font-size: 1.6rem;
            color: var(--royal-emerald);
            margin: 0;
        }

        .category-item:hover {
            border-color: var(--rose-gold);
            background-color: var(--emerald-soft);
        }

        /* Product List Grid & Image Clamping */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-bottom: 80px;
        }

        .product-card {
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 400px; /* Constrains image height perfectly */
            object-fit: cover; /* Prevents stretching */
            border: 1px solid var(--emerald-soft);
            margin-bottom: 15px;
        }
        
        .product-card h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .product-price {
            color: var(--rose-gold-deep);
            font-family: 'Jost', sans-serif;
            font-weight: 400;
        }

        /* Utilities */
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2rem;
        }

        .no-bottom-gap {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 20px;
            }
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            .hero-text {
                width: 90%;
                padding: 20px 30px;
            }
            .brand-logo-img {
                height: 90px !important; 
            }
            .brand-title {
                font-size: 1.4rem !important;
            }
            .product-card img {
                height: 300px; /* Slightly shorter on mobile */
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container navbar">
        <a href="<?= BASE_URL; ?>index.php" style="display: flex; align-items: center; gap: 20px; text-decoration: none;">
            <img src="<?= BASE_URL; ?>assets/images/logo.png" alt="Ayana Boutique Logo" class="brand-logo-img" style="height: 130px; width: auto; object-fit: contain;">
            <span class="brand-title" style="font-size: 2rem; color: var(--rose-gold); font-weight: 400;">Ayana Boutique</span>
        </a>

        <nav class="nav-links">
            <a href="<?= BASE_URL; ?>categories.php">Collection</a>
            <a href="<?= BASE_URL; ?>about.php">Our Story</a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="<?= BASE_URL; ?>account.php">Account</a>
                <a href="<?= BASE_URL; ?>logout.php">Sign Out</a>
            <?php else: ?>
                <a href="<?= BASE_URL; ?>login.php">Sign In</a>
            <?php endif; ?>
            
            <a href="<?= BASE_URL; ?>cart.php" style="color: var(--rose-gold);">
                Cart ( <span id="cart-count"><?= function_exists('cart_count_total') ? cart_count_total() : 0; ?></span> )
            </a>
        </nav>
    </div>
</header>