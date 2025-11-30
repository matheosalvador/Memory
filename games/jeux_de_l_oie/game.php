<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../utils/helper.php';

// --- Récupération des paramètres POST ---
$players = isset($_POST['playerCount']) ? intval($_POST['playerCount']) : 2;
$mode = isset($_POST['mode']) && $_POST['mode'] === "pvai" ? "pvai" : "pvp";

// Sécurisation du nombre de joueurs
if ($players < 2 || $players > 4) $players = 2;

// --- Récupération des noms de joueurs ---
$playerNames = isset($_POST['playerName']) && is_array($_POST['playerName']) ? $_POST['playerName'] : [];
for ($i = 0; $i < $players; $i++) {
    if (!isset($playerNames[$i]) || empty(trim($playerNames[$i]))) {
        $playerNames[$i] = "Joueur " . ($i + 1);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu de l'Oie - Partie</title>
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/style.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
</head>

<body class="game-page">

<?php include "../../partials/header-terminé.php"; ?>

<div class="game-container">

    <h1>🎲 Jeu de l'Oie</h1>

    <p>
        <strong>Joueurs :</strong> <?= $players ?>  
        | <strong>Mode :</strong> <?= strtoupper($mode) ?>
    </p>

    <!-- Plateau -->
    <div class="board" id="board"></div>

    <!-- Actions -->
    <div class="actions">
        <button id="rollDiceBtn">Lancer le dé</button>
        <p id="diceResult">Résultat : -</p>
        <p id="turnInfo">Tour du joueur 1</p>
        <p id="caseInfo">Prochaine case : -</p>
    </div>

</div>

<!-- Injection des variables JS -->
<script>
    window.PLAYER_COUNT = <?= $players ?>;
    window.GAME_MODE = "<?= $mode ?>";
    window.PLAYER_NAMES = <?= json_encode($playerNames, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
</script>

<script src="<?= getBaseUrl(); ?>/assets/js/game.js"></script>

</body>
</html>
