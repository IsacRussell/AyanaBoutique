<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Create Account';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'An account with this email already exists.';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
            if ($insert->execute([$name, $email, $password_hash])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $name;
                redirect(base_url('account.php'));
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}

require __DIR__ . '/includes/header.php';
?>
<section class="section" style="padding-top: 40px; min-height: 60vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 500px; margin: 0 auto;">
        <div class="section-head" style="text-align: center; margin-bottom: 40px;">
            <span class="eyebrow">Join The Collection</span>
            <h2>Create Account</h2>
        </div>
        <?php if ($error): ?>
            <div style="background: #F0DCDD; color: #9B5661; padding: 12px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post" style="border: 1px solid var(--emerald-soft); padding: 40px; background: #fff;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--emerald); margin-bottom: 8px;">Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid var(--emerald-soft); font-family: 'Jost', sans-serif; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--emerald); margin-bottom: 8px;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid var(--emerald-soft); font-family: 'Jost', sans-serif; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--emerald); margin-bottom: 8px;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid var(--emerald-soft); font-family: 'Jost', sans-serif; box-sizing: border-box;">
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="width: 100%; padding: 16px; background: var(--emerald); color: var(--off-white); border: none; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer;">Register</button>
            <p style="text-align: center; margin-top: 20px; font-size: 0.85rem; color: var(--ink-soft);">Already have an account? <a href="<?= e(base_url('login.php')) ?>" style="color: var(--rose-gold); text-decoration: none;">Sign In</a></p>
        </form>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>