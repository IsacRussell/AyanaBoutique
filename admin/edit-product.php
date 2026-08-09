<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect(base_url('admin/login.php'));
}

$id = (int)($_GET['id'] ?? 0);
$categories = get_all_categories($pdo);
$message = '';

// Fetch existing product data
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    redirect(base_url('admin/products.php'));
}

// Fetch existing sizes and stock to pre-fill the text box
$sizeStmt = $pdo->prepare('SELECT * FROM product_sizes WHERE product_id = ?');
$sizeStmt->execute([$id]);
$existingSizes = $sizeStmt->fetchAll();
$sizeStringArray = [];
foreach ($existingSizes as $sz) {
    $sizeStringArray[] = $sz['size_name'] . ':' . $sz['stock_qty'];
}
$currentSizeStock = implode(', ', $sizeStringArray);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $category_id = (int) $_POST['category_id'];
    $price = (float) $_POST['price'];
    $description = trim($_POST['description']);
    $fabric = trim($_POST['fabric']);
    $color = trim($_POST['color']);
    
    // Check if a new main image was uploaded
    $mainImageName = $product['main_image'];
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $mainImageName = time() . '_' . basename($_FILES['product_image']['name']);
        $targetPath = dirname(__DIR__) . '/' . UPLOAD_URL_PATH . $mainImageName; 
        move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath);
        
        // Optional: delete old image to save server space
        @unlink(dirname(__DIR__) . '/' . UPLOAD_URL_PATH . $product['main_image']);
    }

    try {
        $pdo->beginTransaction();
        
        // 1. Update the main product details
        $updateStmt = $pdo->prepare('UPDATE products SET category_id = ?, name = ?, slug = ?, description = ?, fabric = ?, color = ?, price = ?, main_image = ? WHERE id = ?');
        $updateStmt->execute([$category_id, $name, $slug, $description, $fabric, $color, $price, $mainImageName, $id]);
        
        // 2. Wipe old sizes and insert the updated ones
        $delSizes = $pdo->prepare('DELETE FROM product_sizes WHERE product_id = ?');
        $delSizes->execute([$id]);
        
        $sizeStockInput = trim($_POST['size_stock'] ?? '');
        if (!empty($sizeStockInput)) {
            $pairs = explode(',', $sizeStockInput);
            $stmtSize = $pdo->prepare('INSERT INTO product_sizes (product_id, size_name, stock_qty) VALUES (?, ?, ?)');
            foreach ($pairs as $pair) {
                $parts = explode(':', $pair);
                if (count($parts) == 2) {
                    $stmtSize->execute([$id, trim($parts[0]), (int)trim($parts[1])]);
                }
            }
        }

        $pdo->commit();
        $message = "Silhouette '$name' successfully updated!";
        
        // Refresh product data so the form shows the latest changes
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        $currentSizeStock = $sizeStockInput;

    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product | Ayana Boutique</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif; background-color: #FAF6F0; color: #2C2620; margin: 0; padding: 40px; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 1px solid #DCE8E3; padding-bottom: 20px; }
        .nav h1 { font-family: 'Cinzel', serif; color: #0B4F3F; margin: 0; }
        .nav a { text-decoration: none; color: #0B4F3F; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; }
        .form-box { background: #fff; padding: 40px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; text-transform: uppercase; color: #0B4F3F; margin-bottom: 8px; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #DCE8E3; font-family: 'Jost', sans-serif; box-sizing: border-box; }
        button { width: 100%; padding: 16px; background-color: #0B4F3F; color: #fff; border: none; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; margin-top: 10px; }
        button:hover { background-color: #146356; }
        .msg { padding: 15px; margin-bottom: 20px; background: #DCE8E3; color: #0B4F3F; border-left: 4px solid #0B4F3F; }
        .current-image { margin-bottom: 15px; border: 1px solid #DCE8E3; padding: 10px; text-align: center; background: #FAF6F0; }
    </style>
</head>
<body>
    <div class="nav">
        <h1>Edit Silhouette</h1>
        <a href="products.php">← Back to Inventory</a>
    </div>

    <div class="form-box">
        <?php if ($message): ?><div class="msg"><?= e($message) ?></div><?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?= e($product['name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                            <?= e($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Price (MYR)</label>
                <input type="number" step="0.01" name="price" value="<?= e($product['price']) ?>" required>
            </div>
            
            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Fabric</label>
                    <input type="text" name="fabric" value="<?= e($product['fabric']) ?>">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Color</label>
                    <input type="text" name="color" value="<?= e($product['color']) ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label>Sizes & Stock (Format -> Size:Qty, Size:Qty)</label>
                <input type="text" name="size_stock" value="<?= e($currentSizeStock) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"><?= e($product['description']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Main Image (Leave blank to keep current image)</label>
                <?php if ($product['main_image']): ?>
                    <div class="current-image">
                        <img src="<?= e(base_url(UPLOAD_URL_PATH . $product['main_image'])) ?>" style="max-height: 120px; width: auto;">
                        <p style="font-size: 0.75rem; margin-top: 8px; color: #B76E79;">Current Image</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="product_image" accept="image/*">
            </div>
            
            <button type="submit">Update Silhouette</button>
        </form>
    </div>
</body>
</html>