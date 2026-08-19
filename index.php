<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Bridal Attire, Sarees & Suits';
$activePage = 'home';

$categories = get_all_categories($pdo);

// Fetch 3 featured products for the new 3-column grid
$featuredStmt = $pdo->query(
    'SELECT p.*, c.name AS category_name, c.slug AS category_slug
     FROM products p JOIN categories c ON c.id = p.category_id
     WHERE p.status = "active" AND p.is_featured = 1
     ORDER BY p.created_at DESC LIMIT 3'
);
$featured = $featuredStmt->fetchAll();

if (!$featured) {
    $featuredStmt = $pdo->query(
        'SELECT p.*, c.name AS category_name, c.slug AS category_slug
         FROM products p JOIN categories c ON c.id = p.category_id
         WHERE p.status = "active"
         ORDER BY p.created_at DESC LIMIT 3'
    );
    $featured = $featuredStmt->fetchAll();
}

require __DIR__ . '/includes/header.php';
?>

<div class="container hero-new">
    <span class="eyebrow" style="display:flex; align-items:center; gap:8px;">
        The Ayana Collection 
        <span style="display:flex; gap:4px;">
            <div style="width:8px; height:8px; border-radius:50%; background:var(--rose-gold-soft);"></div>
            <div style="width:8px; height:8px; border-radius:50%; background:var(--emerald-soft);"></div>
            <div style="width:8px; height:8px; border-radius:50%; background:var(--rose-gold-deep);"></div>
        </span>
    </span>
    <h1 class="cinzel">WHERE TRADITION <br>MEETS <span class="accent-italic">ELEGANCE.</span></h1>
    <p>Handwoven silks, hand-finished silhouettes. Made for the moments your family will carry forward.</p>
    <a href="<?= e(base_url('categories.php')) ?>" class="btn-rounded">Shop the collection ↗</a>
</div>

<div class="hero-visual-new">
    <img src="<?= e(base_url('assets/images/hero-placeholder.jpg')) ?>" alt="Ayana Boutique bridal collection">
</div>

<div class="container">
    <div class="features-row">
        <div class="feature-item">
            <strong>Authentic Heritage</strong>
            Direct from looms in India, preserving generational craft.
        </div>
        <div class="feature-item">
            <strong>Secure Processing</strong>
            Encrypted payments directly through Stripe.
        </div>
        <div class="feature-item">
            <strong>Considered Sizing</strong>
            Made to fit properly, packaged beautifully.
        </div>
        <div class="feature-item">
            <strong>Dedicated Support</strong>
            Assistance to find the piece meant for you.
        </div>
    </div>
</div>

<div class="container section" style="padding-top: 0;">
    <h2 class="cinzel" style="font-size:2.4rem; max-width: 400px; margin-bottom: 40px; line-height: 1.2;">
        SEVEN SILHOUETTES, <br><span class="accent-italic">ONE STORY.</span>
    </h2>
    <div class="category-list-wrapper">
        <?php foreach ($categories as $cat): ?>
        <a href="<?= e(base_url('category.php?slug=' . $cat['slug'])) ?>" class="category-list-item">
            <span>— <?= e($cat['name']) ?></span>
            <span style="color: var(--ink-soft);">↗</span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?php if ($featured): ?>
<div class="container section">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom: 40px;">
        <h2 class="cinzel" style="font-size:2.4rem; line-height:1.2; margin:0;">
            THIS SEASON'S <br><span class="accent-italic">FAVOURITES.</span>
        </h2>
        <a href="<?= e(base_url('categories.php')) ?>" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--emerald); padding-bottom:2px;">View All ↗</a>
    </div>
    
    <div class="featured-grid">
        <?php foreach ($featured as $p): ?>
        <a href="<?= e(base_url('product.php?slug=' . $p['slug'])) ?>" class="featured-card">
            <img src="<?= e(product_image_url($p['main_image'])) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <span style="font-size:0.7rem; color:var(--ink-soft); text-transform:uppercase; letter-spacing:1px;"><?= e($p['category_name']) ?></span>
                    <h3><?= e($p['name']) ?></h3>
                </div>
                <div style="width:30px; height:30px; border-radius:50%; background:var(--off-white); display:flex; align-items:center; justify-content:center; color:var(--emerald);">↗</div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="container newsletter-section">
    <span style="display:inline-flex; gap:4px; margin-bottom:16px;">
        <div style="width:10px; height:10px; border-radius:50%; background:var(--emerald-soft);"></div>
        <div style="width:10px; height:10px; border-radius:50%; background:var(--rose-gold-soft);"></div>
        <div style="width:10px; height:10px; border-radius:50%; background:var(--rose-gold-deep);"></div>
    </span>
    <h2 class="cinzel" style="font-size:2.2rem; margin-bottom: 10px;">STORIES, ARRIVALS AND <br><span class="accent-italic">OCCASION DRESSING.</span></h2>
    <p style="color:var(--ink-soft); font-size:0.95rem;">Join the list to receive first access to new pieces and releases.</p>
    <form class="newsletter-form">
        <input type="email" placeholder="Your email address" required>
        <button type="submit" class="btn-rounded">Join the list</button>
    </form>
</div>

<div class="massive-banner">
    <div>
        <span class="eyebrow" style="color:var(--emerald-soft); border:1px solid var(--emerald-soft); padding:4px 12px; border-radius:20px; display:inline-block;">Private Enquiries</span>
        <h2 class="cinzel" style="margin-top:20px;">FIND THE PIECE THAT <br><span class="accent-italic" style="color:var(--off-white);">HOLDS YOUR STORY.</span></h2>
    </div>
    <a href="<?= e(base_url('contact.php')) ?>" class="btn-rounded" style="background:var(--off-white); color:var(--emerald);">Speak with Ayana ↗</a>
</div>

<div class="container">
    <h1 class="giant-text">AYANA</h1>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>