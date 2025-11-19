<?php

function checkEmailExists($email, $id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM main_user WHERE email = :email AND id != :id");
    $stmt->execute([
        ':email' => $email,
        ':id'    => $id
    ]);
    return $stmt->fetch() !== false;
}

function updateUser($email, $password, $id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("UPDATE main_user SET email=?, mdp=? WHERE id=?");
    return $stmt->execute([$email, $password, $id]);
}