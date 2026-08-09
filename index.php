<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/cart_functions.php';

require_once __DIR__ . '/includes/header.php';
?>

<div class="hero-section">
    <img src="<?= BASE_URL; ?>assets/images/hero-placeholder.jpg" alt="Bridal Collection">
    <div class="hero-text">
        <h1>Timeless Elegance for Your Special Day</h1>
        <p class="tagline">Discover the heritage of the Venusian Weave.</p>
    </div>
</div>

<div class="container no-bottom-gap">
    <h2 class="section-title">Curated Ensembles</h2>
    
    <div class="category-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM categories LIMIT 6");
        while ($cat = $stmt->fetch()):
        ?>
            <a href="<?= BASE_URL; ?>category.php?id=<?= $cat['id']; ?>" class="category-item">
                <h3><?= e($cat['name']); ?></h3>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>