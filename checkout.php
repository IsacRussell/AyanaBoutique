<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';
require_once __DIR__ . '/includes/stripe.php';

$pageTitle = 'Checkout';
$items = cart_items();

if (!$items) {
    redirect(base_url('cart.php'));
}

$subtotal = cart_subtotal();
$shipping = (float) SHIPPING_FEE;
$total = $subtotal + $shipping;

$errors = [];
$old = [
    'customer_name' => '', 'email' => '', 'phone' => '',
    'address_line1' => '', 'address_line2' => '', 'city' => '', 'state' => '', 'pincode' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    foreach (array_keys($old) as $field) {
        $old[$field] = trim($_POST[$field] ?? '');
    }

    if ($old['customer_name'] === '') $errors[] = 'Please enter your full name.';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if ($old['phone'] === '' || !preg_match('/^[0-9+\-\s]{7,20}$/', $old['phone'])) $errors[] = 'Please enter a valid phone number.';
    if ($old['address_line1'] === '') $errors[] = 'Please enter your address.';
    if ($old['city'] === '') $errors[] = 'Please enter your city.';
    if ($old['state'] === '') $errors[] = 'Please enter your state.';
    if ($old['pincode'] === '' || !preg_match('/^[0-9A-Za-z\-\s]{4,10}$/', $old['pincode'])) $errors[] = 'Please enter a valid PIN code.';

    if (!$errors) {
        $orderNumber = generate_order_number();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare(
                'INSERT INTO orders (order_number, customer_name, email, phone, address_line1, address_line2, city, state, pincode, subtotal, shipping_fee, total_amount, currency, status)
                 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, "pending")'
            );
            $stmt->execute([
                $orderNumber, $old['customer_name'], $old['email'], $old['phone'],
                $old['address_line1'], $old['address_line2'], $old['city'], $old['state'], $old['pincode'],
                $subtotal, $shipping, $total, strtoupper(CURRENCY_CODE),
            ]);
            $orderId = (int) $pdo->lastInsertId();

            $itemStmt = $pdo->prepare(
                'INSERT INTO order_items (order_id, product_id, product_name, size, unit_price, quantity, subtotal)
                 VALUES (?,?,?,?,?,?,?)'
            );
            $lineItemsForStripe = [];
            foreach ($items as $item) {
                $itemStmt->execute([
                    $orderId, $item['product_id'], $item['name'], $item['size'],
                    $item['price'], $item['qty'], $item['price'] * $item['qty'],
                ]);
                $lineItemsForStripe[] = [
                    'name'  => $item['name'],
                    'size'  => $item['size'],
                    'price' => $item['price'],
                    'qty'   => $item['qty'],
                ];
            }
            if ($shipping > 0) {
                $lineItemsForStripe[] = ['name' => 'Shipping', 'size' => '', 'price' => $shipping, 'qty' => 1];
            }

            $session = stripe_create_checkout_session(
                $lineItemsForStripe,
                base_url('success.php') . '?session_id={CHECKOUT_SESSION_ID}',
                base_url('cancel.php') . '?order=' . urlencode($orderNumber),
                $old['email'],
                $orderNumber
            );

            $upd = $pdo->prepare('UPDATE orders SET stripe_session_id = ? WHERE id = ?');
            $upd->execute([$session['id'], $orderId]);

            $pdo->commit();

            redirect($session['url']);
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errors[] = 'We could not connect to the payment gateway. Please try again in a moment, or contact us if the problem continues.';
            // For diagnosing setup issues (e.g. Stripe keys not yet configured), check your server error log:
            error_log('Ayana checkout error: ' . $e->getMessage());
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<nav class="breadcrumb container">
    <a href="<?= e(base_url('index.php')) ?>">Home</a>
    <span class="sep">/</span>
    <a href="<?= e(base_url('cart.php')) ?>">Cart</a>
    <span class="sep">/</span>
    <span class="current">Checkout</span>
</nav>

<section class="section" style="padding-top: 10px;">
    <div class="container">
        <h1 style="margin-bottom: 34px;">Checkout</h1>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="checkout-layout">
            <form method="post" novalidate>
                <?= csrf_field() ?>
                <h3 style="margin-bottom: 20px;">Shipping Details</h3>
                <div class="form-grid">
                    <div class="form-field full">
                        <label for="customer_name">Full Name</label>
                        <input type="text" id="customer_name" name="customer_name" value="<?= e($old['customer_name']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?= e($old['phone']) ?>" required>
                    </div>
                    <div class="form-field full">
                        <label for="address_line1">Address Line 1</label>
                        <input type="text" id="address_line1" name="address_line1" value="<?= e($old['address_line1']) ?>" required>
                    </div>
                    <div class="form-field full">
                        <label for="address_line2">Address Line 2 (optional)</label>
                        <input type="text" id="address_line2" name="address_line2" value="<?= e($old['address_line2']) ?>">
                    </div>
                    <div class="form-field">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= e($old['city']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" value="<?= e($old['state']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="pincode">PIN Code</label>
                        <input type="text" id="pincode" name="pincode" value="<?= e($old['pincode']) ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 10px;">Continue to Payment</button>
                <p style="font-size:0.78rem; text-align:center; margin-top:14px; color: var(--ink-soft);">You'll be redirected to Stripe's secure checkout to complete payment.</p>
            </form>

            <div class="summary-box">
                <h3 style="margin-bottom: 20px;">Order Summary</h3>
                <?php foreach ($items as $item): ?>
                    <div class="mini-line-item">
                        <span><?= e($item['name']) ?><?= !empty($item['size']) ? ' (' . e($item['size']) . ')' : '' ?> × <?= (int) $item['qty'] ?></span>
                        <span><?= e(format_price($item['price'] * $item['qty'])) ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row" style="margin-top: 18px;"><span>Subtotal</span><span><?= e(format_price($subtotal)) ?></span></div>
                <div class="summary-row"><span>Shipping</span><span><?= $shipping > 0 ? e(format_price($shipping)) : 'Complimentary' ?></span></div>
                <div class="summary-row total"><span>Total</span><span><?= e(format_price($total)) ?></span></div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>