<?php
// index.php — Page de configuration du Jeu de l'Oie (PVP / PVsIA)
// Cette page génère un formulaire permettant de sélectionner :
// - Nombre de joueurs (2, 3, 4)
// - Type de joueurs (Humains / IA)
// - Noms des joueurs
// - Difficulté des IA (IA-D3 par défaut)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de l'Oie – Configuration</title>
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <!-- Lien vers style.css -->
    <link rel="stylesheet" href="../../assets/css/style.css">

</head>
<body>
<?php include "../../partials/header-terminé.php"; ?>
<div class="config-container">
    <h1>⚙ Configuration du Jeu de l'Oie</h1>

    <form action="game.php" method="POST" class="config-form">

        <!-- Choix du nombre de joueurs -->
        <label for="playerCount">Nombre de joueurs :</label>
        <select name="playerCount" id="playerCount" required>
            <option value="2">2 joueurs</option>
            <option value="3">3 joueurs</option>
            <option value="4">4 joueurs</option>
        </select>

        <hr>

        <!-- Section joueurs dynamiques (remplie via JS) -->
        <div id="playersConfig"></div>

        <hr>

        <!-- Bouton de lancement -->
        <button type="submit" class="btn-start">🚀 Lancer la partie</button>
    </form>
</div>

<!-- Script JS qui gère l'affichage dynamique des joueurs -->
<script src="../../assets/js/index.js"></script>

</body>
</html>
