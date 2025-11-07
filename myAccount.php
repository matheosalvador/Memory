<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require('utils/helper.php');
require('utils/database.php');
require('actions/login_action.php');
require_once 'utils/update_last_activity.php';

// Connexion à la base
$pdo = getPDO();

// Alerte si la connexion est un succès
if (isset($_SESSION['success'])): ?>
    <div class="alert-success">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}

// Récupérer les infos utilisateur à partir de l'id stocké dans la session
$stmt = $pdo->prepare("SELECT id, pseudo, email FROM main_user WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Si l'utilisateur n'existe pas (cas rare)
if (!$user) {
    echo "<p class='title-acc'>Utilisateur introuvable.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/myaccount.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <title>My Account</title>
</head>

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
include 'partials/header-terminé.php';
?>
<body>
    <div class="flex-acc">
        <img class="img" src="assets/images/Account-Logo.png" alt="logoaccount">
    </div>

    <div>
        <span class="title-acc fs-35">Profil</span>
    </div>

    <hr class="line-acc">

    <div class="w-5">
        <p class="title-acc">Your pseudo: <strong><?= htmlspecialchars($user['pseudo']); ?></strong></p>
    </div>
    <div>
        <p class="title-acc">Your email: <strong><?= htmlspecialchars($user['email']); ?></strong></p>
    </div>
</body>
<?php include 'partials/footer-terminé.php'; ?>
</html>
