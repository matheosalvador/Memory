<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../../utils/helper.php'; 
require_once '../../utils/update_last_activity.php';
require_once '../../utils/fct-scores.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/contact-scores.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <title>Score</title>
</head>
<body>

    <?php 
    $currentPage = basename($_SERVER['PHP_SELF']);

    include __DIR__ . '/../../partials/header-terminé.php'; ?>

    <!-- Text introduction -->
    <p class="startg">Scores</p>
    <p class="startj">Here you can see the scores by a rank system, the game mode, the player name, </p>
    <p class="startj">the game mode difficulty, the time and date.</p>

    <!-- Search form -->
    <form method="get" action="" class="search-form">
        <input type="text" name="pseudo" placeholder="looking for a player?" value="<?= isset($_GET['pseudo']) ? htmlspecialchars($_GET['pseudo']) : '' ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Scores table -->
    <div class="scorea">
        <table id="bodyta">
            <thead class="intern">
                <tr>
                    <th class="scoreb">#</th>
                    <th>Game</th>
                    <th>Player name</th>
                    <th>Difficulty</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="bodytable">
                <?php $position = 1; ?>
                <?php foreach(getScores() as $score): ?>
                    <?php
                        // Vérifie si le joueur connecté est celui de la ligne
                        $isCurrentUser = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$score['user_id'];
                    ?>
                    <tr class="<?= $isCurrentUser ? 'highlight' : '' ?>">
                        <td class='scoreb'><?= $position++; ?></td>
                        <td class="scoreb"><?= htmlspecialchars($score['game_name']) ?></td>
                        <td class="scoreb"><?= htmlspecialchars($score['player_name']) ?></td>
                        <td class="scoreb"><?= getDifficultyLabel($score['difficulty']) ?></td>
                        <td class="scoreb"><?= parseScore($score['time']) ?></td>
                        <td class="scoreb"><?= parseDate($score['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Memory game section -->
    <div class="bloc1">
        <div class="lefttxt">
            <h3 class="titlemem">The memory game</h3>
            <p class="mainmem">You will make mistakes. You might forget a move. But that doesn’t define you. It’s about how well you remember, how clearly you think, and how fiercely you compete. Every card you flip, every match you make — it counts.</p>
            <a href="index.php" class="playbutton">Play</a>
        </div>
        <div>
            <img class="right-image" src="../../assets/images/memory_sec.png" alt="memory_image">
        </div>
    </div>
    <script src="<?= getBaseUrl(); ?>/assets/js/burger.js"></script>

    <?php include "../../partials/footer-terminé.php"; ?>

</body>
</html>
