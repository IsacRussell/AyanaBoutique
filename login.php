<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Sign In';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect(base_url('account.php'));
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top: 40px; min-height: 60vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 500px; margin: 0 auto;">
        <div class="section-head" style="text-align: center; margin-bottom: 40px;">
            <span class="eyebrow">Welcome Back</span>
            <h2>Sign In</h2>
        </div>

        <?php if ($error): ?>
            <div style="background: #F0DCDD; color: #9B5661; padding: 12px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" style="border: 1px solid var(--emerald-soft); padding: 40px; background: #fff;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--emerald); margin-bottom: 8px;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid var(--emerald-soft); font-family: 'Jost', sans-serif; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--emerald); margin-bottom: 8px;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid var(--emerald-soft); font-family: 'Jost', sans-serif; box-sizing: border-box;">
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="width: 100%; padding: 16px; background: var(--emerald); color: var(--off-white); border: none; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer;">Sign In</button>
            
            <p style="text-align: center; margin-top: 20px; font-size: 0.85rem; color: var(--ink-soft);">
                New to Ayana Boutique? <a href="<?= e(base_url('register.php')) ?>" style="color: var(--rose-gold); text-decoration: none;">Create an Account</a>
            </p>
        </form>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>