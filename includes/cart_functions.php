<?php
require_once __DIR__ . '/db.php';

/**
 * Fetches cart items for the currently logged-in user from the database.
 */
function cart_items() {
    global $pdo;

    // If user is not logged in, they don't have a persistent database cart
    if (!isset($_SESSION['user_id'])) {
        return [];
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare(
        'SELECT ci.id AS cart_row_id, ci.product_id, ci.size_name AS size, ci.qty, 
                p.name, p.price, p.main_image 
         FROM cart_items ci
         JOIN products p ON p.id = ci.product_id
         WHERE ci.user_id = ?'
    );
    $stmt->execute([$user_id]);
    $rows = $stmt->fetchAll();

    $full_cart_items = [];
    foreach ($rows as $row) {
        // Use cart_row_id as the array key so updating/deleting specific rows is precise
        $full_cart_items[$row['cart_row_id']] = [
            'cart_row_id' => $row['cart_row_id'],
            'product_id'  => $row['product_id'],
            'size'        => $row['size'],
            'qty'         => (int)$row['qty'],
            'name'        => $row['name'],
            'price'       => (float)$row['price'],
            'image'       => $row['main_image']
        ];
    }

    return $full_cart_items;
}

/**
 * Calculates the total cost of items in the user's database cart.
 */
function cart_subtotal() {
    $items = cart_items();
    $subtotal = 0;

    foreach ($items as $item) {
        $subtotal += ($item['price'] * $item['qty']);
    }

    return $subtotal;
}

/**
 * Gets the total item count for the header navigation badge.
 */
function cart_count_total() {
    $items = cart_items();
    $count = 0;
    foreach ($items as $item) {
        $count += $item['qty'];
    }
    return $count;
}