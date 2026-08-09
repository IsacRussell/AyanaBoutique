<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

if (!isset($_SESSION['user_id'])) {
    redirect(base_url('login.php'));
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$userStmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$userStmt->execute([$user_id]);
$user = $userStmt->fetch();

// Fetch customer orders
$orderStmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
$orderStmt->execute([$user_id]);
$orders = $orderStmt->fetchAll();

$pageTitle = 'My Account';
require __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top: 40px; min-height: 60vh;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <div class="section-head" style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <span class="eyebrow">Client Portal</span>
                <h2>Welcome, <?= e($user['name']) ?></h2>
            </div>
            <a href="<?= e(base_url('logout.php')) ?>" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--rose-gold); text-decoration: none;">Sign Out</a>
        </div>

        <div style="background: #fff; border: 1px solid var(--emerald-soft); padding: 30px; margin-bottom: 40px;">
            <h3 style="font-family: 'Cinzel', serif; color: var(--emerald); font-size: 1.2rem; margin-bottom: 15px;">Account Details</h3>
            <p style="color: var(--ink-soft); font-size: 0.95rem; margin-bottom: 8px;"><strong>Email:</strong> <?= e($user['email']) ?></p>
            <p style="color: var(--ink-soft); font-size: 0.95rem;"><strong>Member Since:</strong> <?= e(date('F j, Y', strtotime($user['created_at']))) ?></p>
        </div>

        <h3 style="font-family: 'Cinzel', serif; color: var(--emerald); font-size: 1.4rem; margin-bottom: 20px;">Order History</h3>
        
        <?php if (!$orders): ?>
            <div style="background: #fff; border: 1px solid var(--emerald-soft); padding: 40px; text-align: center; color: var(--ink-soft);">
                <p>You haven't placed any orders yet.</p>
                <a href="<?= e(base_url('categories.php')) ?>" class="btn btn-primary" style="margin-top: 15px; display: inline-block;">Explore Collection</a>
            </div>
        <?php else: ?>
            <div style="background: #fff; border: 1px solid var(--emerald-soft); overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--emerald-soft); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--emerald);">
                            <th style="padding: 15px;">Order #</th>
                            <th style="padding: 15px;">Date</th>
                            <th style="padding: 15px;">Total</th>
                            <th style="padding: 15px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $ord): ?>
                        <tr style="border-bottom: 1px solid var(--off-white-alt); font-size: 0.9rem;">
                            <td style="padding: 15px; font-weight: 500;"><?= e($ord['order_number']) ?></td>
                            <td style="padding: 15px; color: var(--ink-soft);"><?= e(date('M j, Y', strtotime($ord['created_at']))) ?></td>
                            <td style="padding: 15px;"><?= e(format_price($ord['total_amount'])) ?></td>
                            <td style="padding: 15px;"><span style="text-transform: uppercase; font-size: 0.75rem; padding: 4px 10px; background: var(--emerald-soft); color: var(--emerald);"><?= e($ord['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>