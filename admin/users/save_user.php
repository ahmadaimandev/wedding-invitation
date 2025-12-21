<?php
// admin/users/save_user.php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Case 1: AJAX Status Update
    if (isset($_POST['update_status'])) {
        $id = (int) $_POST['id'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ? AND username != 'admin'");
        $stmt->bind_param("si", $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        $stmt->close();
        exit;
    }

    // Case 2: Full Form (Add or Edit)
    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $username = sanitize($_POST['username']);
    $full_name = sanitize($_POST['full_name']);
    $ic_number = sanitize($_POST['ic_number']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = $_POST['password'];

    if (empty($username) || empty($full_name)) {
        $_SESSION['error'] = "Username and Full Name are required.";
        redirect('index.php');
    }

    if ($id) {
        // --- EDIT MODE ---
        // Check if username already taken by another user
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $check->bind_param("si", $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $_SESSION['error'] = "Username already taken.";
            redirect('index.php');
        }

        if (!empty($password)) {
            // Update with password
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET username=?, full_name=?, ic_number=?, email=?, phone=?, password=? WHERE id=?");
            $stmt->bind_param("ssssssi", $username, $full_name, $ic_number, $email, $phone, $hashed, $id);
        } else {
            // Update without password
            $stmt = $conn->prepare("UPDATE users SET username=?, full_name=?, ic_number=?, email=?, phone=? WHERE id=?");
            $stmt->bind_param("sssssi", $username, $full_name, $ic_number, $email, $phone, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['success'] = "Admin updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating admin: " . $stmt->error;
        }

    } else {
        // --- ADD MODE ---
        if (empty($password)) {
            $_SESSION['error'] = "Password is required for new accounts.";
            redirect('index.php');
        }

        // Check if username exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $_SESSION['error'] = "Username already exists.";
            redirect('index.php');
        }

        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, full_name, ic_number, email, phone, password, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
        $stmt->bind_param("ssssss", $username, $full_name, $ic_number, $email, $phone, $hashed);

        if ($stmt->execute()) {
            $_SESSION['success'] = "New admin added successfully!";
        } else {
            $_SESSION['error'] = "Error adding admin: " . $stmt->error;
        }
    }

    $conn->close();
    redirect('index.php');
} else {
    redirect('index.php');
}
?>