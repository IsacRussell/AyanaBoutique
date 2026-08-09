<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Checkout Cancelled';
$orderNumber = trim($_GET['order'] ?? '');

// Mark the pending order as cancelled, if we can find it — keeps the admin orders list clean.
if ($orderNumber !== '') {
    $stmt = $pdo->prepare('UPDATE orders SET status = "cancelled" WHERE order_number = ? AND status = "pending"');
    $stmt->execute([$orderNumber]);
}

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container confirmation-box">
        <span class="eyebrow">Checkout Cancelled</span>
        <h1>No Payment Was Taken</h1>
        <p>You cancelled the payment before it completed. Your cart is still saved, so you can pick up right where you left off whenever you're ready.</p>
        <a href="<?= e(base_url('cart.php')) ?>" class="btn btn-primary" style="margin-top: 20px;">Return to Cart</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>