<?php
session_start();
include 'db.php';
include 'log_action.php';

// Log the logout action if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    logAction($conn, $user_id, "User logged out");
}

// Clear all session data and destroy the session
session_unset();
session_destroy();

// Redirect to login page with logout message
header("Location: login.php?logout=1");
exit;
?>
