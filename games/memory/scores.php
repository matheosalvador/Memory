<?php 
session_start();

require_once '../../utils/helper.php'; 

require_once '../../utils/fct-scores.php';

?>


<!DOCTYPE html>

<html lang="en"> <!-- language define to english-->
    <head>
        <meta charset="utf-8"> <!-- every character set here-->
        <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\contact-scores.css">
        <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\main.css">
        <title>The memory game</title>
    </head>
    <body>

        <?php include "../../partials\header-terminé.php" ?>

        <!-- smol text :>  -->
        <p class="startg">Scores</p>
        <p class="startj">Here you can see the scores by a rank system, the game mode, the player name, </p>
        <p class="startj">the game mode difficulty, the time and date.</p>

        <form method="get" action="" class="search-form">
            <input type="text" name="pseudo" placeholder="looking for a player?" value="<?= isset($_GET['pseudo']) ? htmlspecialchars($_GET['pseudo']) : '' ?>">
            <button type="submit">Search</button>
        </form>

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
                    <tr>
                        <td class='scoreb'>
                            <?php echo $position++; ?>
                        </td>
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
        <div class="bloc1">
            <div class="lefttxt">
                <h3 class="titlemem">The memory game</h3>
                <p class="mainmem">You will make mistakes. You might forget a move. But that doesn’t define you. It’s about how well you remember, how clearly you think, and how fiercely you compete. Every card you flip, every match you make — it counts.</p>
                <a href="#" class="playbutton">Play</a>
            </div>
            <div>
                <img class="right-image" src="../../assets/images/memory_sec.png" alt="memory_image">
            </div>
        </div>

        <?php include "../../partials/footer-terminé.php" ?>

    </body>
</html>
