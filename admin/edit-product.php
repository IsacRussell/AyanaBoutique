<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $price = (float)$_POST['price'];
    $sale_price = !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
    $description = trim($_POST['description']);
    
    $size_names = $_POST['size_names'] ?? [];
    $stock_qtys = $_POST['stock_qtys'] ?? [];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE products SET name = ?, category_id = ?, price = ?, sale_price = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $category_id, $price, $sale_price, $description, $product_id]);

        // Re-sync Dynamic Sizes
        $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?")->execute([$product_id]);
        if (!empty($size_names)) {
            $stmtSize = $pdo->prepare("INSERT INTO product_sizes (product_id, size_name, stock_qty) VALUES (?, ?, ?)");
            for ($i = 0; $i < count($size_names); $i++) {
                $sName = trim($size_names[$i]);
                $sQty = isset($stock_qtys[$i]) ? (int)$stock_qtys[$i] : 0;
                
                if (!empty($sName)) {
                    $stmtSize->execute([$product_id, $sName, $sQty]);
                }
            }
        }

        // Handle Main Image Override
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '_main_' . basename($_FILES['main_image']['name']);
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], __DIR__ . '/../uploads/' . $imageName)) {
                $pdo->prepare("UPDATE products SET main_image = ? WHERE id = ?")->execute([$imageName, $product_id]);
            }
        }

        // Handle Gallery Appends (View 2, 3, 4)
        $stmtGallery = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
        $gallery_fields = ['view_2', 'view_3', 'view_4'];
        foreach ($gallery_fields as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                $imgName = time() . '_' . $field . '_' . basename($_FILES[$field]['name']);
                if (move_uploaded_file($_FILES[$field]['tmp_name'], __DIR__ . '/../uploads/' . $imgName)) {
                    $stmtGallery->execute([$product_id, $imgName]);
                }
            }
        }

        $pdo->commit();
        $message = "<div style='color: #0B4F3F; background: #DCE8E3; padding: 15px; margin-bottom: 20px; border-radius: 4px;'>Product updated successfully!</div>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        $message = "<div style='color: #9B5661; background: #F0DCDD; padding: 15px; margin-bottom: 20px; border-radius: 4px;'>Database Error: " . $e->getMessage() . "</div>";
    }
}

// Fetch Product & Sizes
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) { die("Product not found."); }

$stmtSizes = $pdo->prepare("SELECT * FROM product_sizes WHERE product_id = ?");
$stmtSizes->execute([$product_id]);
$current_sizes = $stmtSizes->fetchAll();

$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product | Ayana Admin</title>
    <style>
        /* UNIFIED FLUID ADMIN CSS */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Jost', sans-serif; background: #FAF6F0; color: #2C2620; }
        
        .sidebar { width: 260px; background: #0B4F3F; color: #fff; position: fixed; top: 0; left: 0; height: 100vh; padding: 40px 25px; overflow-y: auto; z-index: 100; }
        .sidebar h2 { font-family: 'Cinzel', serif; color: #B76E79; margin-bottom: 40px; font-size: 1.8rem; }
        .sidebar a { color: #DCE8E3; text-decoration: none; display: block; margin-bottom: 18px; font-size: 1.05rem; transition: color 0.3s; }
        .sidebar a:hover, .sidebar a.active { color: #B76E79; font-weight: 500; }
        
        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); min-height: 100vh; }
        h1 { font-family: 'Cinzel', serif; color: #0B4F3F; margin: 0 0 30px 0; font-size: 2.2rem; }
        
        .form-container { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 900px; }
        .form-group { margin-bottom: 24px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #0B4F3F; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; }
        input[type="text"], input[type="number"], select, textarea, input[type="file"] { width: 100%; padding: 12px; border: 1px solid #DCE8E3; border-radius: 4px; font-family: 'Jost', sans-serif; background: #fff; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #B76E79; }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn { padding: 15px 30px; background: #0B4F3F; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; width: 100%; transition: background 0.3s; }
        .btn:hover { background: #146356; }

        .size-row { display: flex; gap: 15px; margin-bottom: 10px; align-items: center; }
        .btn-remove-size { background: #9B5661; color: #fff; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background 0.3s; }
        .btn-remove-size:hover { background: #7A424C; }
        .btn-add-size { background: #DCE8E3; color: #0B4F3F; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; font-weight: 500; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; transition: background 0.3s; display: inline-block; width: auto; margin-bottom: 24px; }
        .btn-add-size:hover { background: #C4D6CE; }
        
        @media (max-width: 1024px) {
            .sidebar { width: 220px; }
            .main-content { margin-left: 220px; width: calc(100% - 220px); padding: 30px; }
        }
        @media (max-width: 768px) {
            body { display: block; }
            .sidebar { position: static; width: 100%; height: auto; padding: 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 15px; }
            .sidebar h2 { margin-bottom: 0; width: 100%; text-align: center; }
            .sidebar a { margin-bottom: 0; font-size: 0.95rem; display: inline-block; }
            .main-content { margin-left: 0; width: 100%; padding: 20px; }
            .grid-2 { grid-template-columns: 1fr; }
            .size-row { flex-wrap: wrap; }
            .btn-remove-size { width: 100%; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Ayana Admin</h2>
    <a href="index.php">Orders Dashboard</a>
    <a href="products.php">Manage Inventory</a>
    <a href="add-product.php">Add New Product</a>
    <a href="logout.php" style="margin-top: 40px; color: #B76E79;">Sign Out</a>
</div>

<div class="main-content">
    <h1>Edit Product</h1>
    <a href="products.php" style="color: #B76E79; display: block; margin-bottom: 20px; text-decoration: none;">&larr; Back to Inventory</a>
    
    <?= $message ?>

    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <div class="grid-2">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" value="<?= e($product['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Price (RM)</label>
                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Sale Price (Optional)</label>
                    <input type="number" step="0.01" name="sale_price" value="<?= $product['sale_price'] ?>">
                </div>
            </div>

            <!-- DYNAMIC SIZES UI PRE-FILLED -->
            <div class="form-group">
                <label>Sizes & Stock</label>
                <div id="sizes-container">
                    <?php if (count($current_sizes) > 0): ?>
                        <?php foreach ($current_sizes as $s): ?>
                        <div class="size-row">
                            <input type="text" name="size_names[]" value="<?= e($s['size_name']) ?>" style="flex: 1;" required>
                            <input type="number" name="stock_qtys[]" value="<?= $s['stock_qty'] ?>" min="0" style="flex: 1;" required>
                            <button type="button" class="btn-remove-size" onclick="this.parentElement.remove()">X</button>
                        </div>
                        <?php endendforeach; ?>
                    <?php else: ?>
                        <div class="size-row">
                            <input type="text" name="size_names[]" placeholder="Size Name (e.g. S, 36)" style="flex: 1;" required>
                            <input type="number" name="stock_qtys[]" placeholder="Stock Qty" min="0" style="flex: 1;" required>
                            <button type="button" class="btn-remove-size" onclick="this.parentElement.remove()">X</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" id="add-size-btn" class="btn-add-size">+ Add Another Size</button>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" required><?= e($product['description']) ?></textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Update Main Image (Leave blank to keep current)</label>
                    <div style="margin-bottom: 10px;">
                        <img src="../uploads/<?= e($product['main_image']) ?>" style="height: 100px; border-radius: 4px; object-fit: cover;">
                    </div>
                    <input type="file" name="main_image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Append Gallery View 2 (Optional)</label>
                    <input type="file" name="view_2" accept="image/*">
                </div>
            </div>
            
            <div class="grid-2">
                <div class="form-group">
                    <label>Append Gallery View 3 (Optional)</label>
                    <input type="file" name="view_3" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Append Gallery View 4 (Optional)</label>
                    <input type="file" name="view_4" accept="image/*">
                </div>
            </div>

            <button type="submit" class="btn">Update Inventory</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-size-btn').addEventListener('click', function() {
        const container = document.getElementById('sizes-container');
        const row = document.createElement('div');
        row.className = 'size-row';
        row.innerHTML = `
            <input type="text" name="size_names[]" placeholder="Size Name (e.g. S, 36)" style="flex: 1;" required>
            <input type="number" name="stock_qtys[]" placeholder="Stock Qty" min="0" style="flex: 1;" required>
            <button type="button" class="btn-remove-size" onclick="this.parentElement.remove()">X</button>
        `;
        container.appendChild(row);
    });
</script>

</body>
</html>