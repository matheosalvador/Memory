<?php 
session_start();

require_once __DIR__ . '/utils/fonction_index_a.php';
require_once __DIR__ . '/utils/helper.php';
require_once __DIR__ . '/utils/update_last_activity.php';

// Définir des valeurs par défaut pour éviter les erreurs.
$gamesPlayed = getGamesPlayed();
$playersOnline = getPlayersOnline();
$totalPlayers = getTotalPlayers();

$recordData = getRecordByDifficulty('1');
$recordTime = $recordData['record_time'] ?? 0;
$recordPseudo = $recordData['pseudo'] ?? "N/A";
$recordsBeatenToday = getRecordsBeatenToday('1');

// Formater le record time en mm:ss
$minutes = floor($recordTime / 60);
$seconds = $recordTime % 60;
$recordTimeFormatted = sprintf("%02dm%02d", $minutes, $seconds);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/index.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <title>HOME</title>
</head>

<body>

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
include __DIR__ . '/partials/header-terminé.php'; 
?>

<section class="main">
    <div class="content">
        <h6>OUR ...</h6>
        <h4 class="wline">Start from The power of Memory games</h4>
        <p>Description</p>

        <!-- BOUTON START QUI OUVRE LE MENU -->
        <a href="#" id="openGameMenu" class="button">Start !</a>
    </div>
    <img src="assets/images/Image-dilustration.png" alt="Image d'illustration">
</section>

<!-- MENU DES JEUX  -->
<div id="gameMenu" class="game-menu hidden">
    <div class="game-menu-content">
        <h2>Select a game</h2>

        <a href="games/memory/index.php" class="game-option">🧠 Memory Game</a>
        <a href="games/puissance_4/index.php" class="game-option">⭕ Puissance 4</a>
        <a class="game-option disabled">🔒  Doctor Who (coming soon)</a>

        <button id="closeGameMenu">Close</button>
    </div>
</div>


<section class="games">
    <h3  class="wline" data-audio="assets/audio/accueil/nosjeux.mp3">Our games</h3>
    <div class="games-container">
        <figure>
            <img src="assets/images/memory.jpg" alt="Power of memory game">
            <figcaption data-audio="assets/audio/accueil/memorygame.mp3">Memory Game</figcaption>
        </figure>
        <figure>
            <img src="assets/images/game2.jpg" alt="game2">
            <figcaption data-audio="assets/audio/accueil/doctorwho.mp3">Doctor Who</figcaption>
        </figure>
        <figure>
            <img src="assets/images/game3.jpg" alt="game3">
            <figcaption data-audio="assets/audio/accueil/puissance4.mp3">Puissance 4</figcaption>
        </figure>
    </div>
</section>

<section class="info">
    <h3 class="info-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>

    <div class="info-content">
        <h3 class="info-title">Lorem Ipsum</h3>

        <div class="info-text">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br>
                Suspendisse scelerisque in tortor vitae sollicitudin.<br>
                Aliquam lacus augue, rhoncus eget porta et, egestas ut augue.
            </p>
        </div>

        <div class="info-image">
            <img src="assets/images/image_complementaire.jpg" alt="Image complémentaire">
            <div class="decor" style="top:10%; right:10%;"></div>
        </div>
    </div>
</section>

<section class="stats">
    <img src="assets/images/statsi.jpg" alt="Stats Background" class="stats-background">

    <div class="stats-content">
        <div class="stats-header">
            <h2>Our Game Statistics</h2>
            <p>Discover the current state of the game: number of players, records, and achievements.</p>
        </div>

        <div class="stats-cards">
            <div class="stat-container">
                <p class="stat-number"><?= $gamesPlayed ?></p>
                <p class="stat-label">Games played</p>
            </div>
            <div class="stat-container">
                <p class="stat-number"><?= $playersOnline ?></p>
                <p class="stat-label">Players online</p>
            </div>
            <div class="stat-container">
                <p class="stat-number"><?= $recordTimeFormatted ?></p>
                <p class="stat-label">Record time</p>
            </div>
            <div class="stat-container">
                <p class="stat-number"><?= $totalPlayers ?></p>
                <p class="stat-label">Registered players</p>
            </div>
            <div class="stat-container">
                <p class="stat-number"><?= $recordsBeatenToday ?></p>
                <p class="stat-label">Records broken today</p>
            </div>
        </div>
    </div>
</section>

<section class="team">
    <h3 class="wline" data-audio="assets/audio/accueil/notreequipe.mp3">Our Team</h3>

    <div class="team-layout">
        <div class="members-right">
            <h3 class="main-team-title" data-audio="assets/audio/accueil/mainteam.mp3">Main Team</h3>

            <figure>
                <a href="https://31.media.tumblr.com/ee77592e071b02c0d7c4f13c716cb196/tumblr_mv2b7jklvs1qeafupo1_500.gif">
                    <img src="assets/images/member1.png" alt="Photo de Member #1">
                </a>
                <figcaption data-audio="assets/audio/accueil/francaist.mp3">Member #1</figcaption>
            </figure>

            <figure>
                <a href="https://paypal.me/LucasVeysset">
                    <img src="assets/images/member2.png" alt="Photo de Member #2">
                </a>
                <figcaption data-audio="assets/audio/accueil/francais.mp3">Member #2</figcaption>
            </figure>

            <figure>
                <a href="https://tenor.com/view/cummins-gif-12535975135255283466">
                    <img src="assets/images/member3.png" alt="Photo de Member #3">
                </a>
                <figcaption data-audio="assets/audio/accueil/chinois.mp3">Member #3</figcaption>
            </figure>
        </div>

        <div class="separator"></div>

        <div class="members-external">
            <h3 class="external-title" data-audio="assets/audio/accueil/external.mp3">External</h3>

            <figure>
                <a href="https://linktr.ee/tezc4t">
                    <img src="assets/images/directeur_DA.png" alt="Photo du DA">
                </a>
                <figcaption data-audio="assets/audio/accueil/vietnam.mp3">Directeur DA en interim</figcaption>
            </figure>

            <figure>
                <a href="https://miwa.lol/aomigo">
                    <img src="assets/images/volontaire.png" alt="Photo du volontaire">
                </a>
                <figcaption data-audio="assets/audio/accueil/gaulois.mp3">volunteer</figcaption>
            </figure>
        </div>
    </div>
</section>

<section class="newsletter">
    <div class="newsletter-toptext">
        <h3>Lorem Ipsum</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br>
            Suspendisse scelerisque in tortor vitae sollicitudin. 
            Aliquam lacus augue, rhoncus eget porta et, egestas ut augue.
        </p>
    </div>

    <div class="container">
        <div class="text">
            <h3>Don’t miss a single update!</h3>
            <p>Subscribe to our newsletter and receive directly in your inbox:</p>
            <ul>
                <li style="color: green;">Our latest news</li>
                <li style="color: green;">Exclusive tips</li>
                <li style="color: green;">Special offers reserved for our subscribers</li>
            </ul>
            <p>👉 To sign up, enter your email address in the field provided and click the “Validate” button.</p>
        </div>
        <div class="form">
            <input name="email" type="email" placeholder="Email address">
            <button type="submit">Validate</button>
        </div>
    </div>
</section>


<!-- JS audio -->
 <script>
document.addEventListener("DOMContentLoaded", () => {

    // Audio sur les titres H3 portant un data-audio
    document.querySelectorAll("h3[data-audio]").forEach(title => {
        title.style.cursor = "pointer";

        title.addEventListener("mouseenter", () => {
            const audio = new Audio(title.getAttribute("data-audio"));
            audio.play();
        });
    });

});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("figcaption[data-audio]").forEach(caption => {
        caption.style.cursor = "pointer";
        caption.addEventListener("click", () => {
            new Audio(caption.getAttribute("data-audio")).play();
        });
    });
});
</script>

<!-- JS MENU -->
<script>
const menu = document.getElementById("gameMenu");
const openBtn = document.getElementById("openGameMenu");
const closeBtn = document.getElementById("closeGameMenu");

openBtn.addEventListener("click", (e) => {
    e.preventDefault();
    menu.classList.remove("hidden");
});

// Bouton close
closeBtn.addEventListener("click", () => {
    menu.classList.add("hidden");
});

// Fermer en cliquant en dehors du panneau
menu.addEventListener("click", (e) => {
    if (e.target === menu) { 
        menu.classList.add("hidden");
    }
});
</script>


<script src="<?= getBaseUrl(); ?>/assets/js/burger.js"></script>

<?php include 'partials/footer-terminé.php'; ?>
</body>
</html>
