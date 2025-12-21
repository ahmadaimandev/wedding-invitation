<?php
// config/functions.php

/**
 * Load .env file
 */
function loadEnv($path)
{
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue;

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
    return true;
}

/**
 * Sanitize user input
 */
function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Redirect to a specific URL
 */
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

/**
 * Format date
 */
function formatDate($date)
{
    return date('d M Y, h:i A', strtotime($date));
}
/**
 * Get all site settings
 */
function getSettings($conn)
{
    $settings = [];
    $res = $conn->query("SELECT * FROM site_settings");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $settings;
}
?>