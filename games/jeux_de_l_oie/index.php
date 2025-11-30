<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../utils/helper.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de l'Oie – Configuration</title>

    <!-- Feuilles de style -->
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/style.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
</head>

<body class="config-page">

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

        <!-- Choix du mode de jeu -->
        <label for="mode">Mode de jeu :</label>
        <select name="mode" id="mode">
            <option value="pvp">Joueur vs Joueur</option>
            <option value="pvai">Joueur vs IA</option>
        </select>

        <hr>

        <!-- Champs des noms de joueurs générés via JS -->
        <div id="playersConfig"></div>

        <hr>

        <!-- Lancer la partie -->
        <button type="submit" class="btn-start">🚀 Lancer la partie</button>
    </form>
</div>

<script>
    // Génération dynamique des champs joueurs
    const playerCountSelect = document.getElementById('playerCount');
    const playersConfigDiv = document.getElementById('playersConfig');

    function renderPlayerFields(count) {
        playersConfigDiv.innerHTML = '';
        for (let i = 1; i <= count; i++) {
            const div = document.createElement('div');
            div.className = 'player-block';
            div.innerHTML = `
                <h3>Joueur ${i}</h3>
                <label>Nom :</label>
                <input type="text" name="playerName[]" placeholder="Nom du joueur ${i}" required>
            `;
            playersConfigDiv.appendChild(div);
        }
    }

    renderPlayerFields(playerCountSelect.value);

    playerCountSelect.addEventListener('change', (e) => {
        renderPlayerFields(e.target.value);
    });
</script>

</body>
</html>
