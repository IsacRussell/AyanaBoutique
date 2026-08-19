<?php
// Ensure this is included within an active session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | Ayana Boutique' : 'Ayana Boutique' ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        /* Refined Design Tokens */
        :root {
            --off-white: #FAF6F0;
            --off-white-alt: #F0E8DB;
            --emerald: #0B4F3F;
            --emerald-hover: #146356;
            --emerald-soft: #DCE8E3;
            --rose-gold: #B76E79;
            --rose-gold-deep: #9B5661;
            --rose-gold-soft: #F0DCDD;
            --ink: #2C2620;
            --ink-soft: #5A524A;
        }

        /* Elegant Resets & Animations */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Jost', sans-serif; 
            background-color: var(--off-white); 
            color: var(--ink); 
            line-height: 1.8; 
            -webkit-font-smoothing: antialiased; 
            animation: fadeIn 1.2s ease-in-out;
            overflow-x: hidden;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Typography - Delicate & Spacious */
        h1, h2, h3, h4, h5, h6, .cinzel { 
            font-family: 'Cinzel', serif; 
            font-weight: 400; 
            color: var(--emerald); 
            letter-spacing: 0.04em;
        }
        h1 { font-size: 2.8rem; line-height: 1.2; margin-bottom: 24px; }
        h2 { font-size: 2.2rem; margin-bottom: 16px; }
        .accent-italic { 
            font-family: 'Cormorant Garamond', serif; 
            font-style: italic; 
            color: var(--emerald); 
            font-size: inherit;
        }
        a { text-decoration: none; color: var(--emerald); transition: color 0.4s ease; }

        /* Layout Structure */
        .container { width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 40px; }
        .section { padding: 100px 0; } 
        .section-alt { background-color: var(--off-white-alt); }
        .section-emerald { background-color: var(--emerald); color: var(--off-white); }
        .section-emerald h2, .section-emerald p { color: var(--off-white); }

        /* Navigation - Sticky, Centered & Transparent on Scroll */
        .site-header { 
            padding: 10px 0; 
            background-color: rgba(250, 246, 240, 1); /* Solid off-white by default */
            position: sticky; 
            top: 0;
            z-index: 999; 
            border-bottom: 1px solid var(--emerald-soft); 
            transition: background-color 0.4s ease, backdrop-filter 0.4s ease;
        }
        
        /* The Scrolled State (Glass Effect - Now 30% more transparent) */
        .site-header.scrolled {
            background-color: rgba(250, 246, 240, 0.55); /* Reduced opacity from 0.85 to 0.55 */
            backdrop-filter: blur(12px); /* Frosts the images passing underneath */
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Solid again when the user hovers over the transparent header */
        .site-header.scrolled:hover {
            background-color: rgba(250, 246, 240, 1);
        }

        .nav-flex { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: relative; /* Allows the text to be absolutely centered */
        }
        
        /* Left: Brand Logo */
        .brand-logo-container { 
            display: flex; 
            align-items: center; 
        }
        
        /* Center: Brand Typography */
        .brand-text-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Cinzel', serif; 
            font-size: 1.6rem; 
            color: var(--emerald); 
            font-weight: 400; 
            letter-spacing: 0.1em; 
            text-decoration: none;
            white-space: nowrap;
            text-transform: uppercase;
        }
        
        /* Right: Nav Links */
        .nav-links a { 
            margin-left: 35px; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.15em; 
        }
        .nav-links a:hover { color: var(--rose-gold); }

        /* Buttons - Editorial Outline Style */
        .btn { 
            display: inline-block; 
            padding: 16px 36px; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.15em; 
            text-align: center; 
            cursor: pointer; 
            transition: all 0.4s ease; 
            background: transparent;
        }
        .btn-primary { color: var(--emerald); border: 1px solid var(--emerald); }
        .btn-primary:hover { background-color: var(--emerald); color: var(--off-white); }
        .btn-rose { color: var(--rose-gold); border: 1px solid var(--rose-gold); }
        .btn-rose:hover { background-color: var(--rose-gold); color: var(--off-white); }
        .btn-block { display: block; width: 100%; }
        
        /* Rounded Button Style */
        .btn-rounded {
            border-radius: 30px;
            background-color: var(--emerald);
            color: var(--off-white);
            padding: 14px 32px;
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            cursor: pointer;
        }
        .btn-rounded:hover {
            background-color: var(--emerald-hover);
            color: var(--off-white);
        }

        /* Utility & Details */
        .eyebrow { 
            display: block; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.2em; 
            color: var(--ink); 
            margin-bottom: 16px; 
            font-weight: 500;
        }

        /* --- HOMEPAGE MOCKUP STYLES --- */
        .hero-new {
            padding: 60px 40px 40px;
            text-align: left;
        }
        .hero-new h1 {
            font-size: 5rem;
            line-height: 1.1;
            margin-bottom: 24px;
            max-width: 900px;
        }
        .hero-new p {
            font-size: 1.1rem;
            color: var(--ink-soft);
            max-width: 450px;
            margin-bottom: 30px;
        }

        .hero-visual-new {
            width: calc(100% - 80px);
            margin: 0 auto 80px;
            max-width: 1600px;
        }
        .hero-visual-new img {
            width: 100%;
            height: auto;
            max-height: 80vh;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }

        .features-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            padding: 40px 0;
            border-bottom: 1px solid var(--emerald-soft);
            margin-bottom: 80px;
        }
        .feature-item {
            font-size: 0.85rem;
            color: var(--ink-soft);
            line-height: 1.5;
        }
        .feature-item strong {
            display: block;
            color: var(--emerald);
            font-weight: 500;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75rem;
        }

        .category-list-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 80px;
        }
        .category-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 0;
            border-bottom: 1px solid var(--emerald-soft);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--emerald);
            transition: all 0.3s ease;
        }
        .category-list-wrapper .category-list-item:first-child,
        .category-list-wrapper .category-list-item:nth-child(2) {
            border-top: 1px solid var(--emerald-soft);
        }
        .category-list-item:hover {
            color: var(--rose-gold);
            padding-left: 10px;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .featured-card {
            background-color: var(--off-white-alt);
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            position: relative;
            transition: transform 0.3s ease;
        }
        .featured-card:hover {
            transform: translateY(-5px);
        }
        .featured-card img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .featured-card h3 {
            font-family: 'Jost', sans-serif;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
            color: var(--emerald);
        }
        .featured-card p {
            font-size: 0.9rem;
            color: var(--ink-soft);
        }

        .newsletter-section {
            text-align: center;
            padding: 100px 20px;
        }
        .newsletter-form {
            display: flex;
            justify-content: center;
            gap: 10px;
            max-width: 500px;
            margin: 30px auto 0;
        }
        .newsletter-form input {
            flex: 1;
            padding: 12px 20px;
            border: 1px solid var(--emerald-soft);
            background: transparent;
            border-radius: 30px;
            font-family: 'Jost', sans-serif;
        }
        .newsletter-form input:focus {
            outline: none;
            border-color: var(--emerald);
        }
        .massive-banner {
            background-color: var(--emerald);
            color: var(--off-white);
            padding: 80px 40px;
            border-radius: 20px;
            margin: 0 40px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .massive-banner h2 {
            font-size: 2.5rem;
            margin: 0;
            color: var(--off-white);
            max-width: 500px;
        }
        .giant-text {
            font-family: 'Cinzel', serif;
            font-size: 18vw;
            line-height: 0.8;
            text-align: center;
            background: url('<?= e(base_url('assets/images/hero-placeholder.jpg')) ?>') center/cover;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0;
            padding-bottom: 40px;
        }

        /* --- EXISTING INTERNAL PAGE STYLES --- */
        .category-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 40px; }
        .category-card { display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: transparent; padding: 80px 20px; text-align: center; border: 1px solid var(--emerald-soft); transition: all 0.5s ease; }
        .category-card h3 { color: var(--emerald); font-size: 1.4rem; margin-bottom: 12px; transition: color 0.4s ease; }
        .category-card span { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--ink-soft); transition: color 0.4s ease; }
        .category-card:hover { background-color: var(--off-white-alt); border-color: var(--rose-gold); }
        .category-card:hover h3, .category-card:hover span { color: var(--rose-gold); }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 40px; }
        .product-card { text-align: left; }
        .product-thumb img { width: 100%; height: 380px; object-fit: cover; background-color: var(--off-white-alt); }
        .product-info { margin-top: 16px; }
        .product-info h3 { font-size: 1rem; margin-bottom: 4px; }
        .product-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start; margin-top: 20px; }
        .gallery-main img { width: 100%; max-height: 650px; object-fit: cover; background-color: var(--off-white-alt); }
        .gallery-thumbs { display: flex; gap: 12px; margin-top: 12px; }
        .gallery-thumbs img { width: 70px; height: 90px; object-fit: cover; cursor: pointer; border: 1px solid var(--emerald-soft); opacity: 0.6; transition: all 0.3s ease; }
        .gallery-thumbs img.active, .gallery-thumbs img:hover { opacity: 1; border-color: var(--emerald); }
        .pd-info .pd-title { font-size: 2rem; margin-bottom: 12px; }
        .pd-price { font-size: 1.2rem; color: var(--ink-soft); margin-bottom: 30px; }
        .size-options { display: flex; flex-wrap: wrap; gap: 10px; margin: 12px 0 30px; }
        .size-options input[type="radio"] { display: none; }
        .size-options label { padding: 12px 20px; border: 1px solid var(--emerald-soft); cursor: pointer; font-size: 0.8rem; text-transform: uppercase; transition: all 0.3s ease; }
        .size-options input[type="radio"]:checked + label { border-color: var(--emerald); background: var(--emerald); color: var(--off-white); }

        /* --- RESPONSIVE MEDIA QUERIES FOR MOBILE & TABLET --- */
        @media (max-width: 1024px) {
            .container { padding: 0 20px; }
            .product-layout { grid-template-columns: 1fr; gap: 40px; }
            h1 { font-size: 2.2rem; }
            .hero-new h1 { font-size: 3.5rem; }
            .category-list-wrapper { grid-template-columns: 1fr; }
            .category-list-wrapper .category-list-item:nth-child(2) { border-top: none; }
            .featured-grid { grid-template-columns: repeat(2, 1fr); }
            .massive-banner { flex-direction: column; text-align: center; gap: 30px; }
        }

        @media (max-width: 768px) {
            .nav-flex { flex-direction: column; gap: 15px; text-align: center; }
            
            /* Stacks the absolutely positioned text cleanly on mobile */
            .brand-text-center { position: relative; left: auto; transform: none; margin: 10px 0; }
            
            .nav-links { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin-left: 0; }
            .nav-links a { margin-left: 0; font-size: 0.7rem; }
            .brand-logo-container img { height: 95px !important; }
            .hero-new h1 { font-size: 2.5rem; }
            .hero-visual-new { width: calc(100% - 40px); margin-bottom: 40px; }
            .features-row { grid-template-columns: 1fr 1fr; }
            .featured-grid { grid-template-columns: 1fr; }
            .massive-banner { margin: 0 20px 40px; padding: 40px 20px; }
            .giant-text { font-size: 22vw; padding-bottom: 20px; }
            .section { padding: 60px 0; }
        }
    </style>
</head>
<body>

<header class="site-header" id="mainHeader">
    <div class="container nav-flex">
        
        <!-- Left: Image Logo -->
        <a href="<?= e(base_url('index.php')) ?>" class="brand-logo-container">
            <img src="<?= e(base_url('assets/images/logo.png')) ?>" alt="Ayana Boutique Logo" style="height: 130px; width: auto;">
        </a>
        
        <!-- Center: Text Logo -->
        <a href="<?= e(base_url('index.php')) ?>" class="brand-text-center">
            Ayana Boutique
        </a>
        
        <!-- Right: Navigation -->
        <nav class="nav-links">
            <a href="<?= e(base_url('categories.php')) ?>">Shop</a>
            <a href="<?= e(base_url('about.php')) ?>">Our Story</a>
            <a href="<?= e(base_url('cart.php')) ?>">Cart (<?= function_exists('cart_count_total') ? cart_count_total() : 0; ?>)</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= e(base_url('account.php')) ?>" style="color: var(--emerald);">Account</a>
            <?php else: ?>
                <a href="<?= e(base_url('login.php')) ?>" style="color: var(--rose-gold);">Sign In</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<!-- Dynamic Scroll Script for Glass Header Effect -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    });
</script>