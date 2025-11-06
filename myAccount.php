<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require('utils/helper.php');
require('utils/database.php');
// Connexion à la base
$pdo = getPDO(); // ta fonction qui retourne un objet PDO

// Supposons que tu as stocké l'email du joueur connecté
$userEmail = $_SESSION['email'] ?? null;

// Requête pour récupérer ses infos
$stmt = $pdo->prepare("SELECT pseudo, email FROM main_user WHERE email = :email");
$stmt->execute(['email' => $userEmail]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en"> <!-- language define to english-->
    <head>
        <meta charset="utf-8"> <!-- every character set here-->
        <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\myaccount.css">
        <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\main.css">
        <title>My Account</title>
    </head>

    <?php include 'partials\header-terminé.php' ?>
    <body>
        <div>
            <div class="flex-acc">
                <img class="img" src="assets\images\Account-Logo.png" alt="logoaccount">
            </div>
            </div>
            <div>
                <span class="title-acc fs-35">Profil</span>
            </div>
            </div>

            <hr class="line-acc">
            <?php if ($user): ?>
        <div class="w-5">
            <p class="title-acc">Your pseudo: <strong><?= htmlspecialchars($user['pseudo']); ?></strong></p>
        </div>
        <div>
            <p class="title-acc">Your email: <strong><?= htmlspecialchars($user['email']); ?></strong></p>
        </div>
        <?php else: ?>
            <p class="title-acc">Utilisateur introuvable.</p>
        <?php endif; ?>
        </div>    
    </body>    
    <?php include 'partials\footer-terminé.php' ?>
</html>
