<?php
// auth/login-process.php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, full_name, status FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($user['status'] == 'inactive') {
            $_SESSION['error'] = "Your account is inactive. Please contact the administrator.";
            redirect('../admin/index.php');
        }

        // Support both MD5 (InfinityFree) and bcrypt (localhost) password hashing
        $passwordValid = false;

        // Check if password is MD5 hash (32 characters)
        if (strlen($user['password']) == 32) {
            // MD5 verification
            $passwordValid = (md5($password) === $user['password']);
        } else {
            // Bcrypt verification
            $passwordValid = password_verify($password, $user['password']);
        }

        if ($passwordValid) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_username'] = $user['username'];

            $_SESSION['success'] = "Welcome back, " . $user['full_name'] . "!";
            redirect('../admin/dashboard.php');
        } else {
            $_SESSION['error'] = "Invalid password.";
            redirect('../admin/index.php');
        }
    } else {
        $_SESSION['error'] = "User not found.";
        redirect('../admin/index.php');
    }

    $stmt->close();
    $conn->close();
} else {
    redirect('../admin/index.php');
}
?>