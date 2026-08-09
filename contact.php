<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Contact Us';
$activePage = 'contact';

require __DIR__ . '/includes/header.php';
?>

<nav class="breadcrumb container">
    <a href="<?= e(base_url('index.php')) ?>">Home</a>
    <span class="sep">/</span>
    <span class="current">Contact</span>
</nav>

<section class="section" style="padding-top: 40px; min-height: 55vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 800px; margin: 0 auto; text-align: center;">
        <div class="section-head" style="margin-bottom: 50px;">
            <span class="eyebrow">Get In Touch</span>
            <h2>We Are Here to Help</h2>
            <p style="color: var(--ink-soft); margin-top: 20px; font-size: 1.1rem;">
                Whether you need sizing advice for your ensemble, have a question about a specific weave, or want to check on an order, we would love to hear from you.
            </p>
        </div>
        
        <div style="background-color: transparent; border: 1px solid var(--emerald-soft); padding: 60px 20px; max-width: 500px; margin: 0 auto; transition: all 0.5s ease;">
            <h3 style="color: var(--emerald); font-size: 1.4rem; margin-bottom: 12px; font-family: 'Cinzel', serif;">Call or WhatsApp</h3>
            <a href="tel:0164496868" style="font-size: 1.4rem; color: var(--rose-gold); text-decoration: none; letter-spacing: 0.1em; transition: color 0.4s ease;" onmouseover="this.style.color='var(--emerald)'" onmouseout="this.style.color='var(--rose-gold)'">
                016 449 6868
            </a>
            <p style="color: var(--ink-soft); font-size: 0.85rem; margin-top: 20px; text-transform: uppercase; letter-spacing: 0.1em;">
                Available for Inquiries & Support
            </p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>