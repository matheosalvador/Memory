<?php
session_start();
require('../../utils/helper.php');
require_once '../../utils/update_last_activity.php';
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/puissance4.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <title>Puissance 4</title>
</head>

<body>

<?php include "../../partials/header-terminé.php"; ?>

<!-- POPUP VICTOIRE -->
<div id="win-popup" class="popup hidden" role="dialog" aria-modal="true">
    <div class="popup-content">
        <h2 id="winner-title" 
            data-audio="<?= getBaseUrl(); ?>/assets/audio/footer-contact-puissance4/travailsup.mp3">
            Félicitations !
        </h2>
        <p id="winner-sub">Le joueur <span id="winner-player"></span> a gagné.</p>
        <button class="restartbtn">Recommencer</button>
    </div>
</div>

<!-- POPUP DÉFAITE IA -->
<div id="lose-popup" 
     class="popup hidden" 
     role="dialog" 
     aria-modal="true"
     data-nightmare="<?= getBaseUrl(); ?>/assets/audio/footer-contact-puissance4/looseH.mp3"
     data-warning3="<?= getBaseUrl(); ?>/assets/audio/footer-contact-puissance4/warning3.mp3">
    <div class="popup-content lose">
        <h2 id="lose-title"
            data-audio="<?= getBaseUrl(); ?>/assets/audio/footer-contact-puissance4/sonloose1.mp3">
            Défaite…
        </h2>
        <p id="lose-sub">L'IA t’a battu.</p>
        <button class="restartbtn">Réessayer</button>
    </div>
</div>

<section class="puissance4-game">
    <h1 class="wwline">Puissance 4</h1>
    <p class="wwline">Clique sur une colonne pour déposer un jeton. Le premier qui aligne 4 gagne.</p>

    <div class="game-settings">
        <label for="mode">Mode de jeu :</label>
        <select id="mode">
            <option value="ia" selected>Joueur vs IA</option>
            <option value="pvp">Joueur vs Joueur</option>
        </select>

        <label for="difficulty">Difficulté :</label>
        <select id="difficulty">
            <option value="easy">Facile</option>
            <option value="medium">Moyenne</option>
            <option value="hard">Difficile</option>
        </select>
    </div>

    <div class="controls">
        <div class="current-player">Joueur actuel : <span id="currentPlayer">Rouge</span></div>
        <button id="resetBtn">Nouvelle partie</button>
    </div>

    <!-- IMPORTANT : data-warning ajouté ici pour que le JS puisse lire WARNING_SOUND -->
    <div id="board" class="board" role="grid"
         data-warning="<?= getBaseUrl(); ?>/assets/audio/footer-contact-puissance4/warning.mp3"></div>
</section>

<script src="<?= getBaseUrl(); ?>/assets/js/puissance4.js" defer></script>
<script src="<?= getBaseUrl(); ?>/assets/js/burger.js" defer></script>

<?php include "../../partials/footer-terminé.php"; ?>
<audio id="bgMusic" loop volume="0.6"></audio>
</body>
</html>
