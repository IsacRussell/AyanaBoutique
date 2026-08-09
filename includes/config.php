<?php
// 1. Start the Global Session (This keeps the cart alive!)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Credentials (Update these with your cPanel details)
define('DB_HOST', 'localhost');
define('DB_NAME', 'arcadius_venusbridal');
define('DB_USER', 'arcadius_owner'); // CHANGE THIS
define('DB_PASS', 'R5#8%DOOg[{Y+z7='); // CHANGE THIS

// 3. Site-wide Constants
define('BASE_URL', 'https://venusbridal.arcadiusengine.xyz/');
define('UPLOAD_URL_PATH', 'uploads/');
define('CURRENCY_CODE', 'MYR');
define('SHIPPING_FEE', 15.00);

// 4. Stripe API Keys (We will use these later for checkout)
define('STRIPE_PUBLIC_KEY', 'pk_test_your_public_key');
define('STRIPE_SECRET_KEY', 'sk_test_your_secret_key');