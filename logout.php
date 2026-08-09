<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
redirect(base_url('index.php'));