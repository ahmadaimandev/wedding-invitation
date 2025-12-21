<?php
// admin/users/delete_user.php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

    // check if it's the main admin
    $check = $conn->query("SELECT username FROM users WHERE id = $id");
    $u = $check->fetch_assoc();

    if ($u['username'] == 'admin') {
        if ($is_ajax) {
            echo json_encode(['status' => 'error', 'message' => 'Superadmin cannot be deleted.']);
            exit;
        }
        $_SESSION['error'] = "Superadmin cannot be deleted.";
        redirect('index.php');
    }

    if ($id == $_SESSION['admin_id']) {
        if ($is_ajax) {
            echo json_encode(['status' => 'error', 'message' => 'You cannot delete yourself.']);
            exit;
        }
        $_SESSION['error'] = "You cannot delete your own account.";
        redirect('index.php');
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($is_ajax) {
            echo json_encode(['status' => 'success']);
            exit;
        }
        $_SESSION['success'] = "User deleted successfully.";
    } else {
        if ($is_ajax) {
            echo json_encode(['status' => 'error', 'message' => 'Database error.']);
            exit;
        }
        $_SESSION['error'] = "Error deleting user.";
    }

    $stmt->close();
    $conn->close();
    redirect('index.php');
} else {
    redirect('index.php');
}
?>