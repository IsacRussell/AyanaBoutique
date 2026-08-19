<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("
    SELECT p.id, p.name, p.price, p.main_image, c.name AS category_name,
           (SELECT COALESCE(SUM(stock_qty), 0) FROM product_sizes WHERE product_id = p.id) AS total_stock
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Ayana Admin</title>
    <style>
        /* UNIFIED FLUID ADMIN CSS */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Jost', sans-serif; background: #FAF6F0; color: #2C2620; }
        
        .sidebar { width: 260px; background: #0B4F3F; color: #fff; position: fixed; top: 0; left: 0; height: 100vh; padding: 40px 25px; overflow-y: auto; z-index: 100; }
        .sidebar h2 { font-family: 'Cinzel', serif; color: #B76E79; margin-bottom: 40px; font-size: 1.8rem; }
        .sidebar a { color: #DCE8E3; text-decoration: none; display: block; margin-bottom: 18px; font-size: 1.05rem; transition: color 0.3s; }
        .sidebar a:hover, .sidebar a.active { color: #B76E79; font-weight: 500; }
        
        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); min-height: 100vh; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px; }
        h1 { font-family: 'Cinzel', serif; color: #0B4F3F; margin: 0; font-size: 2.2rem; }
        
        .table-wrapper { width: 100%; overflow-x: auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th, td { padding: 18px; text-align: left; border-bottom: 1px solid #DCE8E3; }
        th { background: #0B4F3F; color: #fff; font-family: 'Cinzel', serif; font-weight: 400; letter-spacing: 1px; white-space: nowrap; }
        
        img.thumb { width: 50px; height: 60px; object-fit: cover; border-radius: 4px; display: block; }
        
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; font-size: 0.85rem; text-transform: uppercase; display: inline-block; transition: background 0.3s; border: none; cursor: pointer; }
        .btn-primary { background: #0B4F3F; color: #fff; }
        .btn-primary:hover { background: #146356; }
        .btn-edit { background: #B76E79; color: #fff; }
        .btn-edit:hover { background: #9B5661; }
        .btn-delete { background: #9B5661; color: #fff; }
        .btn-delete:hover { background: #7A424C; }
        .action-btns { display: flex; gap: 10px; }

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
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Ayana Admin</h2>
    <a href="index.php">Orders Dashboard</a>
    <a href="products.php" class="active">Manage Inventory</a>
    <a href="add-product.php">Add New Product</a>
    <a href="logout.php" style="margin-top: 40px; color: #B76E79;">Sign Out</a>
</div>

<div class="main-content">
    <div class="header-flex">
        <h1>Inventory Management</h1>
        <a href="add-product.php" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price (RM)</th>
                    <th>Total Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><img src="../uploads/<?= e($p['main_image']) ?>" class="thumb" alt=""></td>
                    <td><strong><?= e($p['name']) ?></strong></td>
                    <td><?= e($p['category_name']) ?></td>
                    <td><?= number_format($p['price'], 2) ?></td>
                    <td>
                        <?php if ($p['total_stock'] > 0): ?>
                            <span style="color: #0B4F3F; font-weight: 600;"><?= $p['total_stock'] ?></span>
                        <?php else: ?>
                            <span style="color: #9B5661; font-weight: 600;">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="edit-product.php?id=<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete-product.php?id=<?= $p['id'] ?>" class="btn btn-delete" onclick="return confirm('Permanently delete this piece?');">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>