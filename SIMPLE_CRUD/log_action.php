<?php
// log_action.php

function logAction($conn, $user_id, $action) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $action, $ip, $agent);
    $stmt->execute();
    $stmt->close();
}
?>
