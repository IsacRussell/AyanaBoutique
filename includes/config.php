<?php
// 1. Start the Global Session (This keeps the cart alive!)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Credentials (Update these with your cPanel details)
define('DB_HOST', 'localhost');
define('DB_NAME', 'ayanabou_collection');
define('DB_USER', 'ayanabou_admin'); // CHANGE THIS
define('DB_PASS', 'AQ}[gR[GufE&{N3u'); // CHANGE THIS

// 3. Site-wide Constants
define('BASE_URL', 'https://ayanaboutique.com.my/');
define('UPLOAD_URL_PATH', 'uploads/');
define('CURRENCY_CODE', 'MYR');
define('SHIPPING_FEE', 15.00);

// 4. Stripe API Keys (We will use these later for checkout)
define('STRIPE_PUBLIC_KEY', 'pk_test_your_public_key');
define('STRIPE_SECRET_KEY', 'sk_test_your_secret_key');