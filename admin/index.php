<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Protect the route
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch recent orders (assuming an 'orders' table exists per your Stripe setup)
try {
    $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 50");
    $orders = $stmt->fetchAll();
} catch (Exception $e) {
    $orders = []; // Fallback if table doesn't exist yet
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Dashboard | Ayana Admin</title>
    <style>
        /* UNIFIED FLUID ADMIN CSS */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Jost', sans-serif; background: #FAF6F0; color: #2C2620; }
        
        .sidebar { width: 260px; background: #0B4F3F; color: #fff; position: fixed; top: 0; left: 0; height: 100vh; padding: 40px 25px; overflow-y: auto; z-index: 100; }
        .sidebar h2 { font-family: 'Cinzel', serif; color: #B76E79; margin-bottom: 40px; font-size: 1.8rem; }
        .sidebar a { color: #DCE8E3; text-decoration: none; display: block; margin-bottom: 18px; font-size: 1.05rem; transition: color 0.3s; }
        .sidebar a:hover, .sidebar a.active { color: #B76E79; font-weight: 500; }
        
        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); min-height: 100vh; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px; }
        h1 { font-family: 'Cinzel', serif; color: #0B4F3F; margin: 0; font-size: 2.2rem; }
        
        .table-wrapper { width: 100%; overflow-x: auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th, td { padding: 18px; text-align: left; border-bottom: 1px solid #DCE8E3; }
        th { background: #0B4F3F; color: #fff; font-family: 'Cinzel', serif; font-weight: 400; letter-spacing: 1px; white-space: nowrap; }
        
        @media (max-width: 1024px) {
            .sidebar { width: 220px; }
            .main-content { margin-left: 220px; width: calc(100% - 220px); padding: 30px; }
        }
        @media (max-width: 768px) {
            body { display: block; }
            .sidebar { position: static; width: 100%; height: auto; padding: 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 15px; }
            .sidebar h2 { margin-bottom: 0; width: 100%; text-align: center; }
            .sidebar a { margin-bottom: 0; font-size: 0.95rem; display: inline-block; }
            .main-content { margin-left: 0; width: 100%; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Ayana Admin</h2>
    <a href="index.php" class="active">Orders Dashboard</a>
    <a href="products.php">Manage Inventory</a>
    <a href="add-product.php">Add New Product</a>
    <a href="logout.php" style="margin-top: 40px; color: #B76E79;">Sign Out</a>
</div>

<div class="main-content">
    <div class="header-flex">
        <h1>Orders Dashboard</h1>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Email</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders): ?>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= e($order['id']) ?></td>
                        <td><?= e($order['email']) ?></td>
                        <td>RM <?= number_format($order['total_amount'], 2) ?></td>
                        <td><span style="background:#DCE8E3; color:#0B4F3F; padding:4px 8px; border-radius:4px; font-size:0.8rem; text-transform:uppercase;"><?= e($order['status']) ?></span></td>
                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; color: #9B5661; padding: 30px;">No recent orders found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>