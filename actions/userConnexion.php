<?php
function getUserByEmail($email){
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT id, email, mdp FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // retourne false si aucun résultat
}