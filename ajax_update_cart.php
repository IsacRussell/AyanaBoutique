<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized session.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $cart_row_id = (int)($_POST['key'] ?? 0); // This corresponds to cart_items.id
    $qty = (int)$_POST['qty'];

    // Verify this cart item belongs to the logged-in user
    $chk = $pdo->prepare('SELECT * FROM cart_items WHERE id = ? AND user_id = ?');
    $chk->execute([$cart_row_id, $user_id]);
    $item = $chk->fetch();

    if ($item) {
        if ($qty <= 0) {
            // Delete row if quantity is zero or removed
            $del = $pdo->prepare('DELETE FROM cart_items WHERE id = ?');
            $del->execute([$cart_row_id]);
        } else {
            // Validate against stock table
            $stockStmt = $pdo->prepare('SELECT stock_qty FROM product_sizes WHERE product_id = ? AND size_name = ?');
            $stockStmt->execute([$item['product_id'], $item['size_name']]);
            $stock = $stockStmt->fetchColumn();

            if ($stock !== false && $qty > $stock) {
                echo json_encode(['status' => 'error', 'message' => "Only $stock items available in that size."]);
                exit;
            }

            // Update quantity
            $upd = $pdo->prepare('UPDATE cart_items SET qty = ? WHERE id = ?');
            $upd->execute([$qty, $cart_row_id]);
        }

        echo json_encode(['status' => 'success']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Cart item not found.']);
    exit;
}