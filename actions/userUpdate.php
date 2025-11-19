<?php
function updateUser($email, $password, $id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("UPDATE main_user SET email=?, mdp=? WHERE id=?");
    return $stmt->execute([$email, $password, $id]);
}