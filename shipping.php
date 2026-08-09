<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Shipping & Delivery';
require __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top: 40px;">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <div class="section-head" style="text-align: center; margin-bottom: 50px;">
            <span class="eyebrow">Legal</span>
            <h2>Shipping & Delivery</h2>
        </div>
        <div class="legal-content" style="color: var(--ink-soft);">
            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">1. Processing Time</h3>
            <p style="margin-bottom: 20px;">Orders are typically processed within 3 to 7 business days.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">2. Delivery Timelines</h3>
            <p style="margin-bottom: 20px;">Shipping times are estimates provided by our logistics partners. We are not liable for any third-party courier delays.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">3. International Orders</h3>
            <p>For international shipments, any customs duties, import taxes, or local clearance fees are the sole responsibility of the customer.</p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
