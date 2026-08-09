<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';

// Auto-Setup: Create a default admin if the table is completely empty
$checkStmt = $pdo->query('SELECT COUNT(*) FROM admins');
if ($checkStmt->fetchColumn() == 0) {
    $defaultPass = password_hash('Ayana2026!', PASSWORD_DEFAULT);
    $pdo->query("INSERT INTO admins (username, password_hash) VALUES ('admin', '$defaultPass')");
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect(base_url('admin/index.php'));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        redirect(base_url('admin/index.php'));
    } else {
        $error = 'Invalid credentials. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login | Ayana Boutique</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif; background-color: #FAF6F0; color: #2C2620; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 50px 40px; border: 1px solid #DCE8E3; text-align: center; max-width: 400px; width: 100%; box-shadow: 0 10px 40px rgba(11, 79, 63, 0.05); }
        h1 { font-family: 'Cinzel', serif; color: #0B4F3F; font-size: 1.8rem; margin-bottom: 30px; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #DCE8E3; box-sizing: border-box; font-family: 'Jost', sans-serif; }
        button { width: 100%; padding: 14px; background-color: #0B4F3F; color: #fff; border: none; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: background 0.3s; }
        button:hover { background-color: #146356; }
        .error { color: #B76E79; font-size: 0.9rem; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Ayana Atelier</h1>
        <?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Enter Atelier</button>
        </form>
    </div>
</body>
</html>