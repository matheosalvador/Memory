<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../utils/helper.php'; 
require_once '../../utils/update_last_activity.php';
require_once '../../utils/fct-scores.php';

$pdo = getPDO();

// Récupération de tous les jeux
$gamesStmt = $pdo->query("SELECT id, game_name FROM game ORDER BY game_name ASC");
$games = $gamesStmt->fetchAll(PDO::FETCH_ASSOC);

// Jeu sélectionné via GET (par défaut premier jeu)
$selectedGameId = isset($_GET['game_id']) ? (int)$_GET['game_id'] : ($games[0]['id'] ?? 1);
$searchPseudo = $_GET['pseudo'] ?? '';
$scores = getScores($selectedGameId, $searchPseudo);

// Détection requête AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    ob_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>/assets/css/contact-scores.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <title>Scores</title>
</head>
<body>

<?php 
$currentPage = basename($_SERVER['PHP_SELF']);
if (!$isAjax) include __DIR__ . '/../../partials/header-terminé.php'; 
?>

<p class="startg">Scores</p>
<p class="startj">Select a game to view scores. You can also search by player name.</p>

<!-- Game selection & search form -->
<form id="scoresForm" method="get" action="" class="search-form">
    <select name="game_id">
        <?php foreach($games as $game): ?>
            <option value="<?= $game['id'] ?>" <?= $game['id'] == $selectedGameId ? 'selected' : '' ?>>
                <?= htmlspecialchars($game['game_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="text" name="pseudo" placeholder="Looking for a player?" 
           value="<?= htmlspecialchars($searchPseudo) ?>">
    <button type="submit">Show Scores</button>
</form>

<!-- Scores table -->
<div class="scorea" id="scoresContainer">
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
            <?php foreach($scores as $score): ?>
                <?php
                    $isCurrentUser = isset($_SESSION['user_id']) && 
                                     (int)$_SESSION['user_id'] === (int)$score['user_id'];
                    $scoreDisplay = parseScoreDisplay($score); // dynamique pour tous les jeux
                ?>
                <tr class="<?= $isCurrentUser ? 'highlight' : '' ?>">
                    <td class='scoreb'><?= $position++; ?></td>
                    <td class="scoreb"><?= htmlspecialchars($score['game_name']) ?></td>
                    <td class="scoreb"><?= htmlspecialchars($score['player_name']) ?></td>
                    <td class="scoreb"><?= getDifficultyLabel($score['difficulty']) ?></td>
                    <td class="scoreb"><?= $scoreDisplay ?></td>
                    <td class="scoreb"><?= parseDate($score['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (!$isAjax): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("scoresForm");
    const container = document.getElementById("scoresContainer");

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        fetch('<?= basename($_SERVER['PHP_SELF']) ?>?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('#bodytable');
            if (newTbody) {
                container.querySelector('#bodytable').innerHTML = newTbody.innerHTML;
            }
        })
        .catch(err => console.error('Erreur AJAX:', err));
    });
});
</script>

<script src="<?= getBaseUrl(); ?>/assets/js/burger.js"></script>
<?php include "../../partials/footer-terminé.php"; ?>
<?php endif; ?>

</body>
</html>

<?php
if ($isAjax) {
    echo ob_get_clean();
    exit;
}
?>
