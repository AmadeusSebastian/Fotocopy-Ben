<?php
session_start();
require_once '../config/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../admin/login.php");
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    // Sanitize string inputs
    $name = $conn->real_escape_string(trim($_POST['name'] ?? ''));
    $email = $conn->real_escape_string(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Hash the password using md5 for better compatibility
        $hashed_password = md5($password);
        
        // Prevent duplicate emails
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($check && $check->num_rows == 0) {
            $sql = "INSERT INTO users (name, email, password, created_at) VALUES ('$name', '$email', '$hashed_password', NOW())";
            $conn->query($sql);
        }
    }
    
    // Clean redirect
    header("Location: ../admin/manage_admin.php");
    exit;

} elseif ($action === 'delete') {
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id > 0) {
        // Prevent deleting the currently logged in admin (assuming session 'admin_id' is set on login)
        if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $id) {
            // Cannot delete own account while logged in
        } else {
            // Prevent deleting the last admin
            $check = $conn->query("SELECT COUNT(*) as count FROM users");
            if ($check) {
                $row = $check->fetch_assoc();
                if ($row['count'] > 1) {
                    $conn->query("DELETE FROM users WHERE id = $id");
                }
            }
        }
    }
    
    // Clean redirect
    header("Location: ../admin/manage_admin.php");
    exit;
    
} else {
    // Invalid action
    header("Location: ../admin/manage_admin.php");
    exit;
}
?>