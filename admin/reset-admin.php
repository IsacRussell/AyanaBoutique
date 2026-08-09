<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db.php';

// The password you want to use
$password = 'Ayana2026!';

// Generate a valid PHP bcrypt hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Update the admin user in the database
$stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE username = 'admin'");

if ($stmt->execute([$hash])) {
    echo "<h3 style='color: #0B4F3F; font-family: sans-serif;'>Success! Password hash updated.</h3>";
    echo "<p style='font-family: sans-serif;'><a href='login.php'>Click here to log in</a> with: <strong>Ayana2026!</strong></p>";
    echo "<p style='color: red; font-family: sans-serif;'><strong>IMPORTANT:</strong> Delete this reset-admin.php file from your server immediately after logging in for security.</p>";
} else {
    echo "Database error. Could not update password.";
}
?>