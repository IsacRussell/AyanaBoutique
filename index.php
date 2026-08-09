<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Home';
require __DIR__ . '/includes/header.php';
?>

<style>
    /* Full-Width Edge-to-Edge Hero Banner */
    .hero-banner-full {
        width: 100%;
        max-width: 100vw;
        margin: 0;
        padding: 0;
        line-height: 0; /* Removes the invisible gap under inline images */
        background-color: var(--off-white-alt);
    }
    
    .hero-banner-full img {
        width: 100%;
        height: auto;
        max-height: 85vh; /* Ensures the image doesn't force endless scrolling on desktop */
        object-fit: cover;
        object-position: center top; /* Keeps the focus on the garments */
        display: block;
    }

    /* Introduction Section */
    .intro-section {
        text-align: center;
        padding: 80px 20px;
        background-color: var(--off-white);
    }
    
    .intro-copy {
        max-width: 800px;
        margin: 0 auto;
    }

    .intro-copy h1 {
        margin-bottom: 20px;
        font-size: 2.8rem;
    }

    @media (max-width: 768px) {
        .intro-copy h1 {
            font-size: 2.2rem;
        }
        .hero-banner-full img {
            max-height: 60vh; /* Adjusts beautifully for mobile screens */
        }
    }

    /* Removes the white gap right before the footer */
    .no-bottom-gap {
        padding-bottom: 0 !important;
        margin-bottom: -1px; /* Prevents 1px rendering glitches on some mobile browsers */
    }
</style>

<div class="hero-banner-full">
    <img src="<?= e(base_url('assets/images/hero-placeholder.jpg')) ?>" alt="Ayana Boutique Collection">
</div>

<section class="intro-section">
    <div class="container">
        <div class="intro-copy">
            <span class="eyebrow">Discover the Collection</span>
            <h1>Elegance Woven in Every Thread</h1>
            <p style="color: var(--ink-soft); font-size: 1.1rem; margin-bottom: 35px; line-height: 1.8;">
                Explore our curated selection of authentic Indian bridal and ethnic attire. From timeless, hand-woven Silk Sarees to versatile, modern Salwar Suits, each piece is crafted with heritage and precision.
            </p>
            <a href="<?= e(base_url('categories.php')) ?>" class="btn btn-primary">Shop The Collection</a>
        </div>
    </div>
</section>

<section class="section section-alt no-bottom-gap" style="padding-top: 80px;">
    <div class="container">
        <div class="section-head" style="text-align: center; margin-bottom: 50px;">
            <span class="eyebrow">Signature</span>
            <h2>Curated Ensembles</h2>
        </div>
        
        <div class="category-grid" style="margin-bottom: 0;">
            <a href="<?= e(base_url('category.php?slug=silk-sarees')) ?>" class="category-card" style="text-decoration: none;">
                <h3>Silk Sarees</h3>
                <span>View Collection</span>
            </a>
            
            <a href="<?= e(base_url('category.php?slug=salwar-suits')) ?>" class="category-card" style="text-decoration: none;">
                <h3>Salwar Suits</h3>
                <span>View Collection</span>
            </a>
            
            <a href="<?= e(base_url('category.php?slug=designer-sets')) ?>" class="category-card" style="text-decoration: none;">
                <h3>Designer Sets</h3>
                <span>View Collection</span>
            </a>
        </div>
        
        <div style="text-align: center; padding: 60px 0;">
            <a href="<?= e(base_url('categories.php')) ?>" class="btn btn-rose">Explore All Categories</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>