<?php
// config/database.php

$host = $_ENV['DB_HOST'] ?? 'localhost';
$db = $_ENV['DB_NAME'] ?? 'wedding_db';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$port = $_ENV['DB_PORT'] ?? 3306;
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

try {
    $conn = new mysqli($host, $user, $pass, $db, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset($charset);
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>