<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../utils/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["user_id"];

        //  Changement PP
if (isset($_FILES['picture_change']) && $_FILES['picture_change']['error'] === UPLOAD_ERR_OK) {
        
        //  Création du dossier pour l'image
    $uploadDir = "../userfiles/$id/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
        //  Taille max de l'image
     $maxFileSize = 2 * 1024 * 1024;

        //  Blocage de la taille et du nom 
    $fileTmpPath = $_FILES['picture_change']['tmp_name'];
    $fileSize    = $_FILES['picture_change']['size'];
    $fileName = "Account-Logo.png";
    $destPath = $uploadDir . $fileName;
     
        //  Déplacement du fichier image
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $_SESSION['success'] = "Photo de profil mise à jour avec succès.";
    } else {
        $_SESSION['errors'][] = "Erreur lors du téléchargement du fichier.";
    }
}

// Redirection vers le formulaire
header("Location: ../myAccount.php");
exit;
