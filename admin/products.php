<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect(base_url('admin/login.php'));
}

// Fetch all products
$stmt = $pdo->query('SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC');
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory Dashboard | Ayana Boutique</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif; background-color: #FAF6F0; color: #2C2620; margin: 0; padding: 40px; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 1px solid #DCE8E3; padding-bottom: 20px; }
        .nav h1 { font-family: 'Cinzel', serif; color: #0B4F3F; margin: 0; }
        .nav a { text-decoration: none; color: #B76E79; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; margin-left: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #DCE8E3; font-size: 0.9rem; }
        th { font-family: 'Cinzel', serif; color: #0B4F3F; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; }
        .action-link { text-decoration: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; margin-right: 15px; }
        .edit { color: #0B4F3F; }
        .delete { color: #B76E79; }
    </style>
</head>
<body>
    <div class="nav">
        <h1>Inventory Management</h1>
        <div>
            <a href="index.php">View Orders</a>
            <a href="add-product.php">+ Add Product</a>
        </div>
    </div>
    
    <table>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td>
                <img src="<?= e(base_url(UPLOAD_URL_PATH . $p['main_image'])) ?>" style="width: 50px; height: 60px; object-fit: cover;">
            </td>
            <td><strong><?= e($p['name']) ?></strong></td>
            <td><?= e($p['category_name']) ?></td>
            <td><?= e(format_price($p['price'])) ?></td>
            <td>
                <a href="edit-product.php?id=<?= $p['id'] ?>" class="action-link edit">Edit</a>
                <a href="delete-product.php?id=<?= $p['id'] ?>" class="action-link delete" onclick="return confirm('Are you sure you want to delete this piece? This cannot be undone.');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>