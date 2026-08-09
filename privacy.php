<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Privacy Policy';
require __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top: 40px;">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <div class="section-head" style="text-align: center; margin-bottom: 50px;">
            <span class="eyebrow">Legal</span>
            <h2>Privacy Policy</h2>
        </div>
        <div class="legal-content" style="color: var(--ink-soft);">
            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">1. Information We Collect</h3>
            <p style="margin-bottom: 20px;">When you create an account, browse our categories, or place an order, our database stores your customer details, shipping addresses, and authentication data. This includes essential information such as your name, email address, phone number, and physical address necessary to fulfill your order.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">2. Payment Security</h3>
            <p style="margin-bottom: 20px;">We utilize Stripe as our secure payment gateway to process all transactions. When you enter the checkout process, your card details are handled securely directly on Stripe's servers, ensuring maximum security and PCI compliance. Ayana Boutique does not store or process your raw credit card data on our own servers.</p>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">3. How We Use Your Data</h3>
            <p>The information we collect is strictly used to:</p>
            <ul style="margin-left: 20px; margin-bottom: 20px;">
                <li>Process and fulfill your orders.</li>
                <li>Communicate with you regarding your purchase status, shipping updates, or customer service inquiries.</li>
                <li>Prevent fraudulent transactions.</li>
            </ul>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: var(--emerald);">4. Data Sharing</h3>
            <p>We do not sell, trade, or rent your personal identification information to others. We may share necessary data with trusted third-party service providers solely for the purpose of operating our business (such as our logistics partners for shipping your trousseau or Stripe for processing your payment).</p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
