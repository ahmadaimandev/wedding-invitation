<?php
// auth/auth-check.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect(BASE_URL . 'admin/index.php');
}
?>
