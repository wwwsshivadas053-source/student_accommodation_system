<?php
session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check user role
function userRole() {
    return $_SESSION['role'] ?? null;
}

// Restrict access by role
function restrictAccess($allowedRoles) {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
    
    if (!in_array(userRole(), $allowedRoles)) {
        header("Location: index.php");
        exit();
    }
}

// Get current user info
function getCurrentUser($conn) {
    if (!isLoggedIn()) {
        return null;
    }
    
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
    return $result->fetch_assoc();
}
?>
