<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';
require_once __DIR__ . '/includes/stripe.php';

$pageTitle = 'Order Confirmed';
$sessionId = trim($_GET['session_id'] ?? '');

$order = null;
$errorMessage = null;

if ($sessionId === '') {
    $errorMessage = 'We could not find your order details.';
} else {
    try {
        $session = stripe_retrieve_checkout_session($sessionId);

        $stmt = $pdo->prepare('SELECT * FROM orders WHERE stripe_session_id = ? LIMIT 1');
        $stmt->execute([$sessionId]);
        $order = $stmt->fetch();

        if (!$order) {
            $errorMessage = 'We could not match this payment to an order on file.';
        } elseif (($session['payment_status'] ?? '') === 'paid') {
            if ($order['status'] !== 'paid') {
                $upd = $pdo->prepare('UPDATE orders SET status = "paid", stripe_payment_intent_id = ? WHERE id = ?');
                $upd->execute([$session['payment_intent'] ?? null, $order['id']]);
            }
            cart_clear(); // payment confirmed — safe to empty the cart now
        } else {
            $errorMessage = 'Your payment has not completed yet. If you were charged, please contact us with your order number.';
        }
    } catch (Throwable $e) {
        $errorMessage = 'We could not confirm your payment right now. If you were charged, please contact us and we\'ll sort it out.';
        error_log('Ayana success.php error: ' . $e->getMessage());
    }
}

$itemsForOrder = [];
if ($order) {
    $itStmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id = ?');
    $itStmt->execute([$order['id']]);
    $itemsForOrder = $itStmt->fetchAll();
}

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container confirmation-box">
        <?php if ($order && !$errorMessage): ?>
            <div class="icon">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="margin:0 auto;"><circle cx="12" cy="12" r="10"/><path d="M8 12.5l2.5 2.5 5-5"/></svg>
            </div>
            <span class="eyebrow">Payment Confirmed</span>
            <h1>Thank You, <?= e(explode(' ', $order['customer_name'])[0]) ?></h1>
            <p>Your order has been placed. A confirmation has been noted against the email you provided — we'll be in touch about dispatch.</p>
            <div class="order-number-pill"><?= e($order['order_number']) ?></div>

            <div style="text-align:left; max-width:420px; margin: 30px auto 0; border-top:1px solid rgba(11,79,63,0.15); padding-top: 20px;">
                <?php foreach ($itemsForOrder as $it): ?>
                    <div class="mini-line-item">
                        <span><?= e($it['product_name']) ?><?= !empty($it['size']) ? ' (' . e($it['size']) . ')' : '' ?> × <?= (int) $it['quantity'] ?></span>
                        <span><?= e(format_price($it['subtotal'])) ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row total"><span>Total Paid</span><span><?= e(format_price($order['total_amount'])) ?></span></div>
            </div>

            <a href="<?= e(base_url('index.php')) ?>" class="btn btn-primary" style="margin-top: 30px;">Continue Shopping</a>
        <?php else: ?>
            <span class="eyebrow">Order Status</span>
            <h1>We Need a Moment</h1>
            <p><?= e($errorMessage ?? 'Something went wrong confirming your order.') ?></p>
            <a href="<?= e(base_url('cart.php')) ?>" class="btn btn-outline" style="margin-top: 20px;">Back to Cart</a>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>