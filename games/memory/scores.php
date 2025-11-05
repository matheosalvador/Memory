<?php 

require_once '../../utils/helper.php'; 
require_once '../../utils/database.php';
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

        <?php 
        $pdo = getPDO();

        $pseudo = $_GET['pseudo'] ?? '';

        if ($pseudo) {
            $stmt = $pdo->prepare("
                SELECT s.id, u.pseudo AS player_name, g.game_name, s.difficulty, s.score, s.created_at
                FROM score s
                INNER JOIN main_user u ON s.user_id = u.id
                INNER JOIN game g ON s.game_id = g.id
                WHERE u.pseudo LIKE :pseudo
                ORDER BY s.score ASC
            ");
            $stmt->execute(['pseudo' => "%$pseudo%"]);
        } else {
            $stmt = $pdo->query("
                SELECT s.id, u.pseudo AS player_name, g.game_name, s.difficulty, s.score, s.created_at
                FROM score s
                INNER JOIN main_user u ON s.user_id = u.id
                INNER JOIN game g ON s.game_id = g.id
                ORDER BY s.score ASC
            ");
        }
        $scores = $stmt->fetchAll();
        ?>
        
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
                    <?php
                    $position = 1;
                    foreach ($scores as $score):
                        $difficultylabel = match($score['difficulty']) {
                            '1' => 'easy',
                            '2' => 'medium',
                            '3' => 'hard',
                            default => 'Unknown'
                        };
                        $date = date('Y-m-d', strtotime($score['created_at']));
                    ?>
                    <tr>
                        <td class='scoreb'>
                            <?= $position ?>
                            <?= $position == 1 ? 'st' : ($position == 2 ? 'nd' : ($position == 3 ? 'rd' : 'th')) ?>
                        </td>
                        <td class="scoreb"><?= htmlspecialchars($score['game_name']) ?></td>
                        <td class="scoreb"><?= htmlspecialchars($score['player_name']) ?></td>
                        <td class="scoreb"><?= htmlspecialchars($difficultylabel) ?></td>
                        <td class="scoreb"><?= htmlspecialchars($score['score']) ?></td>
                        <td class="scoreb"><?= htmlspecialchars($date) ?></td>
                    </tr>
                    <?php
                        $position++;
                    endforeach;
                    ?>
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
