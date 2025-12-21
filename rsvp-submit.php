<?php
// rsvp-submit.php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $relationship = sanitize($_POST['relationship']);
    $attendance = sanitize($_POST['attendance']);
    $pax = isset($_POST['pax']) ? (int) $_POST['pax'] : 0;
    $dietary = sanitize($_POST['dietary']);
    $message = sanitize($_POST['message']);

    // Validation
    if (empty($name) || empty($phone) || empty($attendance) || empty($relationship)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        redirect('rsvp.php');
    }

    // Determine Initial Status: If message is provided, set to 'pending' for moderation
    $status = !empty($message) ? 'pending' : 'approved';

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO rsvp (name, email, phone, relationship, attendance, pax, dietary, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssisss", $name, $email, $phone, $relationship, $attendance, $pax, $dietary, $message, $status);

    if ($stmt->execute()) {
        $_SESSION['success'] = "RSVP submitted successfully!";
        redirect('thank-you.php');
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again: " . $stmt->error;
        redirect('rsvp.php');
    }

    $stmt->close();
    $conn->close();
} else {
    redirect('index.php');
}
?>