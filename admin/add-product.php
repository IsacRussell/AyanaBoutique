<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect(base_url('admin/login.php'));
}

$categories = get_all_categories($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $category_id = (int) $_POST['category_id'];
    $price = (float) $_POST['price'];
    $description = trim($_POST['description']);
    $fabric = trim($_POST['fabric']);
    $color = trim($_POST['color']);
    
    // Process Sizes & Calculate Total Stock Automatically
    $sizeStockInput = trim($_POST['size_stock'] ?? '');
    $totalStock = 0;
    $sizeArray = [];
    $sizesString = '';

    if (!empty($sizeStockInput)) {
        $pairs = explode(',', $sizeStockInput);
        foreach ($pairs as $pair) {
            $parts = explode(':', $pair);
            if (count($parts) == 2) {
                $sName = trim($parts[0]);
                $sQty = (int)trim($parts[1]);
                $sizeArray[] = ['name' => $sName, 'qty' => $sQty];
                $totalStock += $sQty; // Adds up all the individual size stocks
            }
        }
        // Extract just the size names (e.g. "S, M") for the frontend display
        $sizesString = implode(', ', array_column($sizeArray, 'name'));
    }

    // Helper function for uploading images
    function uploadImage($fileInputName) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '_' . basename($_FILES[$fileInputName]['name']);
            $targetPath = dirname(__DIR__) . '/' . UPLOAD_URL_PATH . $imageName; 
            move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetPath);
            return $imageName;
        }
        return '';
    }

    $mainImageName = uploadImage('product_image');
    $image2Name = uploadImage('image_2');
    $image3Name = uploadImage('image_3');

    try {
        $pdo->beginTransaction();
        
        // 1. Insert Main Product using the automatically calculated Total Stock and Sizes String
        $stmt = $pdo->prepare('INSERT INTO products (category_id, name, slug, description, fabric, color, price, stock_qty, sizes, main_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$category_id, $name, $slug, $description, $fabric, $color, $price, $totalStock, $sizesString, $mainImageName]);
        
        $newProductId = $pdo->lastInsertId();

        // 2. Insert the specific inventory amounts per size
        if (!empty($sizeArray)) {
            $stmtSize = $pdo->prepare('INSERT INTO product_sizes (product_id, size_name, stock_qty) VALUES (?, ?, ?)');
            foreach ($sizeArray as $sz) {
                $stmtSize->execute([$newProductId, $sz['name'], $sz['qty']]);
            }
        }

        // 3. Insert Gallery Images (if uploaded)
        $imgStmt = $pdo->prepare('INSERT INTO product_images (product_id, image_path, sort_order) VALUES (?, ?, ?)');
        if ($image2Name) { $imgStmt->execute([$newProductId, $image2Name, 1]); }
        if ($image3Name) { $imgStmt->execute([$newProductId, $image3Name, 2]); }

        $pdo->commit();
        $message = "Product '$name' added successfully with size inventory!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product | Ayana Boutique</title>
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
        .upload-row { display: flex; gap: 15px; margin-bottom: 20px; background: #F0E8DB; padding: 15px; border-radius: 4px; }
        .upload-row > div { flex: 1; }
        button { width: 100%; padding: 16px; background-color: #0B4F3F; color: #fff; border: none; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; margin-top: 10px; }
        button:hover { background-color: #146356; }
        .msg { padding: 15px; margin-bottom: 20px; background: #DCE8E3; color: #0B4F3F; border-left: 4px solid #0B4F3F; }
    </style>
</head>
<body>
    <div class="nav">
        <h1>Add New Silhouette</h1>
        <a href="products.php">← Back to Dashboard</a>
    </div>

    <div class="form-box">
        <?php if ($message): ?><div class="msg"><?= e($message) ?></div><?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" required>
            </div>
            
            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Category</label>
                    <select name="category_id" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" required>
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Fabric</label>
                    <input type="text" name="fabric" placeholder="e.g. Pure Pattu Silk">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Color</label>
                    <input type="text" name="color" placeholder="e.g. Royal Emerald">
                </div>
            </div>
            
            <div class="form-group">
                <label>Sizes & Stock (Format -> Size:Qty, Size:Qty)</label>
                <input type="text" name="size_stock" placeholder="S:10, M:5, L:0" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"></textarea>
            </div>
            
            <label style="margin-bottom: 10px;">Product Images</label>
            <div class="upload-row">
                <div>
                    <label style="font-size: 0.7rem;">Main Image *</label>
                    <input type="file" name="product_image" accept="image/*" required style="padding: 6px;">
                </div>
                <div>
                    <label style="font-size: 0.7rem;">View 2</label>
                    <input type="file" name="image_2" accept="image/*" style="padding: 6px;">
                </div>
                <div>
                    <label style="font-size: 0.7rem;">View 3</label>
                    <input type="file" name="image_3" accept="image/*" style="padding: 6px;">
                </div>
            </div>
            
            <button type="submit">Add to Boutique</button>
        </form>
    </div>
</body>
</html>