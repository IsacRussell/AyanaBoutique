<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Categories';
$activePage = 'categories';

$categories = get_all_categories($pdo);

require __DIR__ . '/includes/header.php';
?>

<nav class="breadcrumb container" style="padding-top: 40px; padding-bottom: 0;">
    <a href="<?= e(base_url('index.php')) ?>">Home</a>
    <span class="sep">/</span>
    <span class="current">Categories</span>
</nav>

<section class="section" style="padding-top: 40px;">
    <div class="container">
        <div class="section-head" style="text-align: center; margin-bottom: 50px;">
            <span class="eyebrow">The Full Collection</span>
            <h2>Shop by Category</h2>
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

<?php require __DIR__ . '/includes/footer.php'; ?>