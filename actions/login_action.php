<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../actions/userConnexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['mdp'])) {
        // ✅ Connexion réussie
        $_SESSION['userId'] = $user['id'];
        $_SESSION['success'] = "Connexion réussie ! Bienvenue " . htmlspecialchars($user['email']) . " 👋";

        header('Location: ../index.php');
        exit;
    } else {
        // ❌ Erreur de connexion
        $_SESSION['errors'] = ["Email ou mot de passe incorrect."];
        header('Location: ../login.php');
        exit;
    }
}
