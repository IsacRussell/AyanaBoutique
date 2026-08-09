<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect(base_url('admin/login.php'));
}

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    // 1. Fetch and delete the physical image files from the server
    $stmt = $pdo->prepare('SELECT main_image FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $prod = $stmt->fetch();
    
    if ($prod && !empty($prod['main_image'])) {
        @unlink(dirname(__DIR__) . '/' . UPLOAD_URL_PATH . $prod['main_image']);
    }
    
    $imgStmt = $pdo->prepare('SELECT image_path FROM product_images WHERE product_id = ?');
    $imgStmt->execute([$id]);
    while ($img = $imgStmt->fetch()) {
         @unlink(dirname(__DIR__) . '/' . UPLOAD_URL_PATH . $img['image_path']);
    }

    // 2. Delete the product from the database (Cascades to sizes/gallery automatically)
    $delStmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $delStmt->execute([$id]);
}

redirect(base_url('admin/products.php'));