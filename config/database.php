<?php
// config/database.php

// Auto-detect environment (localhost vs production)
$isLocalhost = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '::1'])
    || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false;

if ($isLocalhost) {
    // LOCAL DEVELOPMENT (XAMPP)
    $host = 'localhost';
    $db = 'wedding_db';
    $user = 'root';
    $pass = '';
} else {
    // PRODUCTION (InfinityFree)
    $host = 'sql207.infinityfree.com';
    $db = 'if0_40767466_wedding_db';
    $user = 'if0_40767466';
    $pass = 'Mbsa0717';
}

$charset = 'utf8mb4';

try {
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        // Log error for debugging (don't show credentials in production)
        error_log("Database connection failed: " . $conn->connect_error);
        die("Connection failed. Please contact administrator.");
    }

    $conn->set_charset($charset);
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    die("Database connection error. Please contact administrator.");
}
?>