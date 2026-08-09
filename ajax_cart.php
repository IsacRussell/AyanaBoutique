<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

header('Content-Type: application/json');

// Ensure user is logged in before adding to cart
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Please sign in to add items to your personal trousseau.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $size = trim($_POST['size'] ?? '');
    $qty_to_add = 1; // Default increment
    
    if (!$product_id || !$size) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a size.']);
        exit;
    }

    // 1. Verify Stock in the Database for this specific size
    $stockStmt = $pdo->prepare('SELECT stock_qty FROM product_sizes WHERE product_id = ? AND size_name = ?');
    $stockStmt->execute([$product_id, $size]);
    $available_stock = $stockStmt->fetchColumn();

    if ($available_stock === false) {
        echo json_encode(['status' => 'error', 'message' => 'Selected size is invalid.']);
        exit;
    }

    // 2. Check how many of this item/size the user already has in their database cart
    $cartCheckStmt = $pdo->prepare('SELECT id, qty FROM cart_items WHERE user_id = ? AND product_id = ? AND size_name = ?');
    $cartCheckStmt->execute([$user_id, $product_id, $size]);
    $existing_cart_item = $cartCheckStmt->fetch();

    $current_cart_qty = $existing_cart_item ? (int)$existing_cart_item['qty'] : 0;

    // 3. Enforce Inventory Limits
    if (($current_cart_qty + $qty_to_add) > $available_stock) {
        echo json_encode(['status' => 'error', 'message' => 'Requested quantity exceeds available stock for this size.']);
        exit;
    }

    // 4. Update or Insert into database `cart_items` table
    if ($existing_cart_item) {
        // Update existing row quantity
        $new_qty = $current_cart_qty + $qty_to_add;
        $updateStmt = $pdo->prepare('UPDATE cart_items SET qty = ? WHERE id = ?');
        $updateStmt->execute([$new_qty, $existing_cart_item['id']]);
    } else {
        // Insert new row
        $insertStmt = $pdo->prepare('INSERT INTO cart_items (user_id, product_id, size_name, qty) VALUES (?, ?, ?, ?)');
        $insertStmt->execute([$user_id, $product_id, $size, $qty_to_add]);
    }

    // Return success along with updated total item count
    echo json_encode([
        'status' => 'success', 
        'cart_count' => cart_count_total()
    ]);
    exit;
}