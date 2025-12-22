<?php
// config/config.php
require_once 'functions.php';

// Load Environment Variables
loadEnv(__DIR__ . '/../.env');

// Site Settings
define('SITE_NAME', 'Our Wedding Invitation');
define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost/wedding-invitation/');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>