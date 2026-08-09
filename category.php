<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$slug = trim($_GET['slug'] ?? '');
$category = $slug ? get_category_by_slug($pdo, $slug) : null;

if (!$category) {
    http_response_code(404);
    $pageTitle = 'Category Not Found';
    require __DIR__ . '/includes/header.php';
    echo '<div class="container empty-state"><h2>Category Not Found</h2><p>That category doesn\'t exist or may have been renamed.</p><a href="' . e(base_url('categories.php')) . '" class="btn btn-primary">Browse Categories</a></div>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $category['name'];
$activePage = 'categories';

$sort = $_GET['sort'] ?? 'newest';
$orderBy = 'p.created_at DESC';
if ($sort === 'price_low')  $orderBy = 'effective_price ASC';
if ($sort === 'price_high') $orderBy = 'effective_price DESC';
if ($sort === 'name')       $orderBy = 'p.name ASC';

$stmt = $pdo->prepare(
    "SELECT p.*, COALESCE(NULLIF(p.sale_price, 0), p.price) AS effective_price
     FROM products p
     WHERE p.category_id = ? AND p.status = 'active'
     ORDER BY $orderBy"
);
$stmt->execute([$category['id']]);
$products = $stmt->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<nav class="breadcrumb container">
    <a href="<?= e(base_url('index.php')) ?>">Home</a>
    <span class="sep">/</span>
    <a href="<?= e(base_url('categories.php')) ?>">Categories</a>
    <span class="sep">/</span>
    <span class="current"><?= e($category['name']) ?></span>
</nav>

<section class="section" style="padding-top: 10px;">
    <div class="container">
        <div class="section-head" style="margin-bottom: 30px;">
            <span class="eyebrow">Category</span>
            <h1><?= e($category['name']) ?></h1>
            <?php if (!empty($category['description'])): ?>
                <p><?= e($category['description']) ?></p>
            <?php endif; ?>
        </div>

        <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 30px; flex-wrap: wrap; gap: 14px;">
            <span style="font-size:0.85rem; color: var(--ink-soft);"><?= count($products) ?> piece<?= count($products) === 1 ? '' : 's' ?></span>
            <form method="get" style="display:flex; align-items:center; gap:10px;">
                <input type="hidden" name="slug" value="<?= e($slug) ?>">
                <label for="sort" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--ink-soft);">Sort</label>
                <select name="sort" id="sort" onchange="this.form.submit()" style="padding:8px 12px; border:1px solid rgba(11,79,63,0.25); border-radius:2px;">
                    <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
                    <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                    <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                    <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name: A–Z</option>
                </select>
            </form>
        </div>

        <?php if (!$products): ?>
            <div class="empty-state">
                <h3>New pieces are on their way</h3>
                <p>This category is being restocked. Please check back soon, or explore another category.</p>
                <a href="<?= e(base_url('categories.php')) ?>" class="btn btn-outline">Browse Categories</a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $p): ?>
                <a href="<?= e(base_url('product.php?slug=' . $p['slug'])) ?>" class="product-card">
                    <div class="product-thumb">
                        <?php if (!empty($p['sale_price'])): ?><span class="badge">Sale</span><?php endif; ?>
                        <img src="<?= e(product_image_url($p['main_image'])) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
                    </div>
                    <div class="product-info">
                        <h3><?= e($p['name']) ?></h3>
                        <div class="product-price">
                            <?php if (!empty($p['sale_price'])): ?>
                                <span class="sale"><?= e(format_price($p['sale_price'])) ?></span>
                                <span class="was"><?= e(format_price($p['price'])) ?></span>
                            <?php else: ?>
                                <?= e(format_price($p['price'])) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>