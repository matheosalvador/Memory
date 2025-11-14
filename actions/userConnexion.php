<?php
function getUserByEmail($email) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT id, email, mdp, pseudo FROM main_user WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}