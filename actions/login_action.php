<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../actions/userConnexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['mdp'])) {
        //  Connexion réussie → on stocke toutes les infos utiles
        $_SESSION['user_id'] = $user['id'];      // ← uniformiser le nom avec ton autre page
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['success'] = "Login successful! Welcome. " . htmlspecialchars($user['pseudo']) . " 👋";

        header('Location: ../myAccount.php');
        exit;
    } else {
        //  Erreur de connexion
        $_SESSION['errors'] = ["Incorrect email or password."];
        header('Location: ../login.php');
        exit;
    }
}
