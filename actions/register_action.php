<?php
// Chemin vers tes fonctions helper et la base
require_once(__DIR__ . '/../utils/helper.php');
require_once(__DIR__ . '/../utils/database.php');

session_start();

$errors = [];
$success = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    // Validation pseudo
    if (strlen($pseudo) < 4) {
        $errors[] = "The pseudo must be at least 4 characters long.";
    }

    // Validation mot de passe
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/', $password)) {
        $errors[] = "The password must contain at least 8 characters, one uppercase letter, one number, and one special character.";
    }

    // Vérification existence email ou pseudo
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM main_user WHERE email = :email OR pseudo = :pseudo");
    $stmt->execute(['email' => $email, 'pseudo' => $pseudo]);
    if ($stmt->fetch()) {
        $errors[] = "Email or pseudo already in use.";
    }

    // Si pas d'erreurs, insertion
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO main_user (email, mdp, pseudo) VALUES (:email, :mdp, :pseudo)");
        $stmt->execute([
            'email' => $email,
            'mdp' => $hashed,
            'pseudo' => $pseudo
        ]);
        $success = "Registration successful! You can now log in.";
    }

    // Stockage des messages pour affichage
    $_SESSION['errors'] = $errors;
    $_SESSION['success'] = $success;
    $_SESSION['old'] = ['email' => $email, 'pseudo' => $pseudo];

    // Redirection vers le formulaire
    header("Location: ../login.php");
    exit;
}
