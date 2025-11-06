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


    <title>HOME</title>
</head>
<body>

<?php include 'partials/header-terminé.php'; ?>

<section class="main">
    <div class="content">
        <img src="assets/images/Image-dilustration.png" alt="Image d'illustration">
        <div class="text">
            <h6>OUR ...</h6>
            <h4 class="wline">Début de lorem sur fibra</h4>
            <p>Description</p>
            <a href="games/memory/index.php" class="button">Start !</a>
        </div>
    </div>
</section>

<section class="games">
    <h3 class="wline">Our games</h3>
    <div class="games-container">
        <figure>
            <img src="assets/images/memory.jpg" alt="Power of memory game">
            <figcaption>Memory Game</figcaption>
        </figure>
        <figure>
            <img src="assets/images/game2.jpg" alt="game2">
            <figcaption>Game 2</figcaption>
        </figure>
        <figure>
            <img src="assets/images/game3.jpg" alt="game3">
            <figcaption>Game 3</figcaption>
        </figure>
    </div>
</section>

<section class="info">
    <div class="infop">
        <span>Lorem ipsum sit amet, consectetur adipiscing elit</span>
    </div>
    <div class="inform">
        <div class="info-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <img id="imagescomplementaire" src="assets/images/image_complementaire.jpg" alt="Image complémentaire">
    </div>
</section>

<!-- Section Stats -->
<!-- Section Stats -->
<section class="stats">
    <!-- Image de fond -->
    <img src="assets/images/statsi.jpg" alt="Stats Background" class="stats-background">

    <!-- Contenu par-dessus l'image -->
    <div class="stats-content">
        <!-- Texte au-dessus -->
        <div class="stats-header">
            <h2>Our Game Statistics</h2>
            <p>Discover the current state of the game: number of players, records, and achievements.</p>
        </div>

        <!-- Cartes des stats -->
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
    <h3 class="wline">Our Team</h3>
    <div class="members">
        <figure>
            <img src="assets/images/member1.png" alt="Photo de Member #1">
            <figcaption>Member #1</figcaption>
        </figure>
        <figure>
            <img src="assets/images/member2.png" alt="Photo de Member #2">
            <figcaption>Member #2</figcaption>
        </figure>
        <figure>
            <img src="assets/images/member3.png" alt="Photo de Member #3">
            <figcaption>Member #3</figcaption>
        </figure>
    </div>
</section>

<section class="newsletter">
    <div class="container">
        <div class="text">
            <h3>Stay informed</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae sollicitudin.</p>
        </div>
        <div class="form">
            <input name="email" type="email" placeholder="Adresse email">
            <button type="submit">Validate</button>
        </div>
    </div>
</section>

<?php include 'partials/footer-terminé.php'; ?>

</body>
</html>
