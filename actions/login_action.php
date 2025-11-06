<?php
<?php
session_start();
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/userConnexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['mdp'])) {
        // Connexion réussie
        $_SESSION['userId'] = $user['id'];
        $_SESSION['flash'][] = "Connexion réussie !";

        // <-- REDIRECTION VERS LA PAGE DE COMPTE
        header('Location: ../account.php');
        exit;
    } else {
        // Erreur de connexion
        $_SESSION['flash'][] = "Email ou mot de passe incorrect.";
        header('Location: ../login.php');
        exit;
    }
}
