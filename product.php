<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$slug = trim($_GET['slug'] ?? '');

$stmt = $pdo->prepare(
    'SELECT p.*, c.name AS category_name, c.slug AS category_slug
     FROM products p JOIN categories c ON c.id = p.category_id
     WHERE p.slug = ? AND p.status = "active" LIMIT 1'
);
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    $pageTitle = 'Product Not Found';
    require __DIR__ . '/includes/header.php';
    echo '<div class="container empty-state"><h2>Product Not Found</h2><p>This piece may have sold out or been removed.</p><a href="' . e(base_url('categories.php')) . '" class="btn btn-primary">Browse Categories</a></div>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $product['name'];

// Gallery images
$imgStmt = $pdo->prepare('SELECT * FROM product_images WHERE product_id = ? ORDER BY id ASC');
$imgStmt->execute([$product['id']]);
$gallery = $imgStmt->fetchAll();

// Fetch sizes from product_sizes table
$stmtSizes = $pdo->prepare("SELECT * FROM product_sizes WHERE product_id = ? AND stock_qty > 0 ORDER BY id ASC");
$stmtSizes->execute([$product['id']]);
$availableSizes = $stmtSizes->fetchAll();

$hasStock = count($availableSizes) > 0;

require __DIR__ . '/includes/header.php';
?>

<nav class="breadcrumb container" style="padding-bottom: 0;">
    <a href="<?= e(base_url('index.php')) ?>">Home</a>
    <span class="sep">/</span>
    <a href="<?= e(base_url('category.php?slug=' . $product['category_slug'])) ?>"><?= e($product['category_name']) ?></a>
    <span class="sep">/</span>
    <span class="current"><?= e($product['name']) ?></span>
</nav>

<section class="container">
    <div class="product-layout">
        
        <div class="gallery">
            <div class="gallery-main">
                <img id="mainProductImage" src="<?= e(product_image_url($product['main_image'])) ?>" alt="<?= e($product['name']) ?>">
            </div>
            
            <div class="gallery-thumbs">
                <img src="<?= e(product_image_url($product['main_image'])) ?>" data-full="<?= e(product_image_url($product['main_image'])) ?>" class="thumb-trigger active" alt="Main view">
                <?php foreach ($gallery as $g): ?>
                    <img src="<?= e(product_image_url($g['image_path'])) ?>" data-full="<?= e(product_image_url($g['image_path'])) ?>" class="thumb-trigger" alt="Additional view">
                <?php endforeach; ?>
            </div>
        </div>

        <div class="pd-info">
            <span class="eyebrow"><?= e($product['category_name']) ?></span>
            <h1 class="pd-title"><?= e($product['name']) ?></h1>

            <div class="pd-price">
                <?php if (!empty($product['sale_price'])): ?>
                    <span style="color: var(--rose-gold);"><?= e(format_price($product['sale_price'])) ?></span>
                    <span class="was" style="text-decoration: line-through; margin-left: 10px; font-size: 0.9rem;"><?= e(format_price($product['price'])) ?></span>
                <?php else: ?>
                    <?= e(format_price($product['price'])) ?>
                <?php endif; ?>
            </div>

            <form id="addToCartForm">
                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">

                <?php if ($availableSizes): ?>
                <div>
                    <span style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--ink-soft);">Select Size</span>
                    <div class="size-options">
                        <?php foreach ($availableSizes as $i => $s): ?>
                            <input type="radio" name="size" id="size-<?= $i ?>" value="<?= e($s['size_name']) ?>" <?= $i === 0 ? 'checked' : '' ?>>
                            <label for="size-<?= $i ?>"><?= e($s['size_name']) ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div style="margin-bottom: 24px; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--emerald)"><path d="M20 6L9 17l-5-5"/></svg>
                    <?= $hasStock ? 'Item is in stock' : '<span style="color: var(--rose-gold);">Out of Stock</span>' ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="padding: 20px; font-size: 0.9rem;" <?= !$hasStock ? 'disabled' : '' ?>>
                    <?= !$hasStock ? 'Out of Stock' : 'Add to Cart' ?>
                </button>
            </form>

            <div style="margin-top: 40px; font-size: 0.9rem; color: var(--ink-soft); line-height: 1.8;">
                <p style="margin-bottom: 16px;"><strong>Description</strong></p>
                <?php if (!empty($product['description'])): ?>
                    <p style="margin-bottom: 24px;"><?= nl2br(e($product['description'])) ?></p>
                <?php endif; ?>
                
                <?php if (!empty($product['fabric'])): ?><div>Fabric: <?= e($product['fabric']) ?></div><?php endif; ?>
                <?php if (!empty($product['color'])): ?><div>Colour: <?= e($product['color']) ?></div><?php endif; ?>
                <?php if (!empty($product['sku'])): ?><div>SKU: <?= e($product['sku']) ?></div><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
document.querySelectorAll('.thumb-trigger').forEach(thumb => {
    thumb.addEventListener('click', function() {
        document.getElementById('mainProductImage').src = this.dataset.full;
        document.querySelectorAll('.thumb-trigger').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>