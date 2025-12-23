<?php
// config/database.php

// Helper to get environment variables securely
function getEnvVar($key, $default = '')
{
    // 1. Check $_ENV (populated by our loadEnv helper locally)
    if (isset($_ENV[$key]))
        return $_ENV[$key];

    // 2. Check getenv() (standard for Vercel/Serverless)
    $val = getenv($key);
    if ($val !== false)
        return $val;

    // 3. Check $_SERVER (fallback)
    if (isset($_SERVER[$key]))
        return $_SERVER[$key];

    return $default;
}

$host = getEnvVar('DB_HOST', 'localhost');
$db = getEnvVar('DB_NAME', 'wedding_db');
$user = getEnvVar('DB_USER', 'root');
$pass = getEnvVar('DB_PASS', '');
$port = getEnvVar('DB_PORT', 3306);
$charset = getEnvVar('DB_CHARSET', 'utf8mb4');

try {
    // Ensure port is an integer
    $port = (int) $port;

    $conn = new mysqli($host, $user, $pass, $db, $port);

    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }

    $conn->set_charset($charset);
} catch (Exception $e) {
    // Log the error (optional) or display a generic message in production
    // For Vercel debugging, we show the message but be careful with secrets
    die("Database Connection Failed. Error: " . $e->getMessage());
}
?>