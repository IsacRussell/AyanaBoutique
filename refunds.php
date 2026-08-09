<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Refunds & Exchanges';
require __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top: 40px;">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <div class="section-head" style="text-align: center; margin-bottom: 50px;">
            <span class="eyebrow">Legal</span>
            <h2>Refund & Exchange Policy</h2>
        </div>
        <div class="legal-content" style="color: var(--ink-soft);">
            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">1. Eligibility</h3>
            <p style="margin-bottom: 20px;">To be eligible for a return or exchange, your kurti must be unworn, unwashed, unaltered, and in the same condition that you received it, with all original tags intact.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">2. Timeframe</h3>
            <p style="margin-bottom: 20px;">Returns or exchange requests must be initiated within 24 hours of receiving the order.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">3. Return Shipping</h3>
            <p style="margin-bottom: 20px;">Unless the item received was damaged, defective, or incorrect, shipping costs for returns are the responsibility of the customer.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">4. Defective Items (Unboxing Video)</h3>
            <p>To claim a refund or exchange for a damaged or defective product, customers are highly encouraged to provide an unedited unboxing/parcel opening video as proof.</p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
