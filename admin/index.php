<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect(base_url('admin/login.php'));
}

$stmt = $pdo->query('SELECT * FROM orders ORDER BY created_at DESC');
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders Dashboard | Ayana Boutique</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif; background-color: #FAF6F0; color: #2C2620; margin: 0; padding: 40px; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 1px solid #DCE8E3; padding-bottom: 20px; }
        .nav h1 { font-family: 'Cinzel', serif; color: #0B4F3F; margin: 0; }
        .nav a { text-decoration: none; color: #B76E79; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; margin-left: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #DCE8E3; font-size: 0.9rem; }
        th { font-family: 'Cinzel', serif; color: #0B4F3F; }
        .status { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase; }
        .status.paid { background: #DCE8E3; color: #0B4F3F; }
        .status.pending { background: #F0DCDD; color: #9B5661; }
    </style>
</head>
<body>
    <div class="nav">
        <h1>Orders Dashboard</h1>
        <div>
            <a href="products.php">Inventory</a>
            <a href="add-product.php">+ Add Product</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <table>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= e($order['order_number']) ?></td>
            <td><?= e($order['customer_name']) ?></td>
            <td><?= e($order['email']) ?></td>
            <td><?= e(format_price($order['total_amount'])) ?></td>
            <td><span class="status <?= e($order['status']) ?>"><?= e($order['status']) ?></span></td>
            <td><?= e(date('M j, Y', strtotime($order['created_at']))) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>