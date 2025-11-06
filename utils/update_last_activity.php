<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/database.php';


if (isset($_SESSION['userId'])) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        UPDATE main_user 
        SET last_activity = NOW() 
        WHERE id = :id
    ");
    $stmt->execute(['id' => $_SESSION['userId']]);
}
