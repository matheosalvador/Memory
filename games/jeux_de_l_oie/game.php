<?php
// game.php - Plateau du Jeu de l'Oie

// Récupération des paramètres
$players = isset($_GET['players']) ? intval($_GET['players']) : 2;
$mode = isset($_GET['mode']) ? htmlspecialchars($_GET['mode']) : 'pvp';

// Sécurisation
if ($players < 2 || $players > 4) {
    $players = 2;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jeu de l'Oie - Partie</title>
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<?php include "../../partials/header-terminé.php"; ?>
<div class="game-container">

    <h1>Jeu de l'Oie</h1>

    <p><strong>Joueurs :</strong> <?php echo $players; ?> | <strong>Mode :</strong> <?php echo strtoupper($mode); ?></p>

    <!-- Zone du plateau -->
    <div class="board" id="board"></div>

    <!-- Zone d'action -->
    <div class="actions">
        <button id="rollDiceBtn">Lancer le dé</button>
        <p id="diceResult">Résultat : -</p>
        <p id="turnInfo">Tour du joueur 1</p>
    </div>

</div>

<script>
    const PLAYER_COUNT = <?php echo $players; ?>;
    const GAME_MODE = "<?php echo $mode; ?>";
</script>
<script src="../../assets/js/game.js"></script>

</body>
</html>
