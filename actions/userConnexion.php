<?php
require_once __DIR__ . '/../utils/database.php';

function getUserByEmail($email) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT id, email, mdp FROM main_user WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
