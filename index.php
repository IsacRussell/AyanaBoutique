<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Bridal Attire, Sarees & Suits';
$activePage = 'home';

$categories = get_all_categories($pdo);

$featuredStmt = $pdo->query(
    'SELECT p.*, c.name AS category_name, c.slug AS category_slug
     FROM products p JOIN categories c ON c.id = p.category_id
     WHERE p.status = "active" AND p.is_featured = 1
     ORDER BY p.created_at DESC LIMIT 8'
);
$featured = $featuredStmt->fetchAll();

if (!$featured) {
    $featuredStmt = $pdo->query(
        'SELECT p.*, c.name AS category_name, c.slug AS category_slug
         FROM products p JOIN categories c ON c.id = p.category_id
         WHERE p.status = "active"
         ORDER BY p.created_at DESC LIMIT 8'
    );
    $featured = $featuredStmt->fetchAll();
}

require __DIR__ . '/includes/header.php';
?>

<section class="hero section">
    <div class="container">
        <div class="hero-copy">
            <span class="eyebrow">The Ayana Trousseau Edit</span>
            <h1>Where Tradition Meets Trousseau</h1>
            <span class="accent-italic">Handwoven silks, hand-finished silhouettes.</span>
            <p class="lede">From your first Chudidhar to your wedding-day Pattu silk, Ayana Boutique curates bridal attire that carries a family's story forward — thread by thread.</p>
        </div>
        <div class="hero-visual">
            <img src="<?= e(base_url('assets/images/hero-placeholder.jpg')) ?>" alt="Ayana Boutique bridal collection">
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head" style="text-align: center; margin-bottom: 40px;">
            <span class="eyebrow">Shop by Category</span>
            <h2>Seven Silhouettes, One Story</h2>
        </div>
        <div class="category-grid">
            <?php foreach ($categories as $cat): ?>
            <a href="<?= e(base_url('category.php?slug=' . $cat['slug'])) ?>" class="category-card">
                <h3><?= e($cat['name']) ?></h3>
                <span>Shop Now</span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($featured): ?>
<section class="section section-alt">
    <div class="container">
        <div class="section-head" style="text-align: center; margin-bottom: 40px;">
            <span class="eyebrow">Handpicked</span>
            <h2>This Season's Favourites</h2>
        </div>
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px;">
            <?php foreach ($featured as $p): ?>
            <a href="<?= e(base_url('product.php?slug=' . $p['slug'])) ?>" class="product-card" style="text-align: center;">
                <div class="product-thumb" style="margin-bottom: 20px;">
                    <?php if (!empty($p['sale_price'])): ?><span class="badge" style="position:absolute; background:var(--rose-gold); color:#fff; padding:4px 12px; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em;">Sale</span><?php endif; ?>
                    <img src="<?= e(product_image_url($p['main_image'])) ?>" alt="<?= e($p['name']) ?>" loading="lazy" style="width:100%; height:auto;">
                </div>
                <div class="product-info">
                    <h3 style="font-size: 1.1rem; color: var(--ink);"><?= e($p['name']) ?></h3>
                    <div class="product-price" style="font-size: 0.9rem; color: var(--ink-soft); margin-top: 8px;">
                        <?php if (!empty($p['sale_price'])): ?>
                            <span class="sale" style="color: var(--rose-gold);"><?= e(format_price($p['sale_price'])) ?></span>
                            <span class="was" style="text-decoration: line-through; opacity: 0.6; margin-left: 8px;"><?= e(format_price($p['price'])) ?></span>
                        <?php else: ?>
                            <?= e(format_price($p['price'])) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section section-emerald">
    <div class="container" style="text-align:center; max-width: 720px;">
        <span class="eyebrow" style="color: var(--rose-gold-soft);">Our Promise</span>
        <h2>Every Weave Has a Reason</h2>
        <p>Each Ayana piece is chosen — or made — in partnership with weaving families across India, so the craft behind your trousseau stays as considered as the occasion it's made for.</p>
        <div style="margin-top: 40px;">
            <a href="<?= e(base_url('about.php')) ?>" class="btn btn-rose">Read Our Story</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>