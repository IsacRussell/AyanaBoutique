<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'About Us';
$activePage = 'about';

require __DIR__ . '/includes/header.php';
?>

<section class="about-hero">
    <div class="container" style="max-width: 720px;">
        <span class="eyebrow">Our Story</span>
        <h1>A Curated Collection Is Never Just Clothing</h1>
        <p class="accent-italic" style="font-size: 1.3rem;">It's a family's history, worn forward.</p>
    </div>
</section>

<section class="section">
    <div class="container about-block">
        <img src="<?= e(base_url('assets/images/placeholder.svg')) ?>" alt="Ayana Boutique atelier">
        <div>
            <span class="eyebrow">How We Began</span>
            <h2>Started at a Wedding, Not a Warehouse</h2>
            <p>Ayana Boutique began the way most good ideas do — with a wedding we couldn't stop thinking about. A grandmother's Pattu silk, re-draped for her granddaughter, stitched a room together in a way no new outfit could have. We started Ayana to hold onto that feeling: attire made to be worn again, remembered, and eventually handed down.</p>
            <p>What began as a small collection of Chudidhars and Salwar Suits has grown into a full bridal house — but the instinct hasn't changed. We still choose fabric the way you'd choose a keepsake.</p>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container about-block reverse">
        <img src="<?= e(base_url('assets/images/placeholder.svg')) ?>" alt="Handloom weaving detail">
        <div>
            <span class="eyebrow">Our Craft</span>
            <h2>Woven by Hand, Chosen by Us</h2>
            <p>We work directly with weaving families across India — from the silk looms behind our Pattu and Silk Sarees to the tailors who finish every Designer Set. Every piece passes through hands before it reaches yours, and we think that should still mean something.</p>
            <p>It's why fabric, drape, and finishing come before trend — every single time.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">What Guides Us</span>
            <h2>Three Things We Don't Compromise On</h2>
        </div>
        <div class="value-grid">
            <div>
                <div class="num">Fabric First</div>
                <h3>Real Silk, Real Zari</h3>
                <p>No synthetic substitutes dressed up as tradition. If it says silk, it's silk.</p>
            </div>
            <div>
                <div class="num">Made to Fit</div>
                <h3>Considered Sizing</h3>
                <p>Detailed size charts and fabric notes on every product, so what arrives is what you expected.</p>
            </div>
            <div>
                <div class="num">Made to Last</div>
                <h3>Heirloom Finishing</h3>
                <p>Finished the way pieces meant to be worn for decades — not one season — deserve to be.</p>
            </div>
        </div>
    </div>
</section>

<section class="section section-emerald">
    <div class="container" style="text-align:center; max-width: 680px;">
        <span class="eyebrow" style="color: var(--rose-gold-soft);">Visit the Collection</span>
        <h2>Begin Your Collection</h2>
        <p>Seven categories, one house of craft — from everyday Kurtis to your wedding-day Pattu silk.</p>
        <a href="<?= e(base_url('categories.php')) ?>" class="btn btn-rose">Shop All Categories</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>