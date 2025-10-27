<?php
include 'db.php';
include 'log_action.php';
session_start();

if (isset($_SESSION['user_id'])) {
    logAction($conn, $_SESSION['user_id'], "User logged out");
}

session_destroy();
header("Location: login.php");
exit;
?>
