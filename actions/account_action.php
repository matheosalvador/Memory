<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../actions/userUpdate.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
    // Initialization des Variables
$errors = [];
$success = "";
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$id = $_SESSION["user_id"];

    // Validation email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email.";
}

if (checkEmailExists($email, $id)) {
    $errors[] = "Email already in use.";
}
    
    // Validation password
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/', $_POST["password"])) {
    $errors[] = "The password must contain at least 8 characters, one uppercase letter, one number, and one special character.";
}

    //  Verification des erreurs avant de sauvegarder  
if (empty($errors)) {
    $result = updateUser($email, $password, $id);
    if($result){
        $success = "Save Done!";

    } else {
        $errors[] = "Save Failed!";
    }
}

else {
    $errors[] = "Errors Detected!";
}

// Stockage des messages pour affichage
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;

// Redirection vers le formulaire
header("Location: ../myAccount.php");
exit;

