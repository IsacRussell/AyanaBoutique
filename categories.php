<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/cart_functions.php';

require_once __DIR__ . '/includes/header.php';
?>

<div class="container" style="padding-top: 60px;">
    <h1 class="section-title">Our Collections</h1>
    <p class="tagline" style="text-align: center; margin-bottom: 40px;">Explore our finest hand-selected heritage pieces.</p>
    
    <div class="category-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
        while ($cat = $stmt->fetch()):
        ?>
            <a href="<?= BASE_URL; ?>category.php?id=<?= $cat['id']; ?>" class="category-item">
                <h3><?= e($cat['name']); ?></h3>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>