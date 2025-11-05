<?php 
require_once '../../utils/database.php'; // include database connction

function getScores() {
    $pdo = getPDO(); // get pdo database connection
    $pseudo = $_GET['pseudo'] ?? ''; // pseudo from url
    if ($pseudo) {
        // if exist, we get sql request from most score table
        $stmt = $pdo->prepare("
            SELECT s.id, u.pseudo AS player_name, g.game_name, s.difficulty, s.time, s.created_at
            FROM score s
            INNER JOIN main_user u ON s.user_id = u.id
            INNER JOIN game g ON s.game_id = g.id
            WHERE u.pseudo LIKE :pseudo
            ORDER BY s.time ASC
        ");
        $stmt->execute(['pseudo' => "%$pseudo%"]); //execute query
    } else {
        // if no pseudo, get all scores
        $stmt = $pdo->query("
            SELECT s.id, u.pseudo AS player_name, g.game_name, s.difficulty, s.time, s.created_at
            FROM score s
            INNER JOIN main_user u ON s.user_id = u.id
            INNER JOIN game g ON s.game_id = g.id
            ORDER BY s.time ASC
        ");
    }

    return $stmt->fetchAll(); // all results as array (table format)
}

function getDifficultyLabel($difficulty) {
    return match($difficulty) {
        '1' => 'easy',
        '2' => 'medium',
        '3' => 'hard',
        default => 'Unknown' // just for the "null" difficulty in case of
    }; // convert numeric difficulty to text
}

function parseScore($score) {
    $timeSec = (int)$score; // convert to integer seconds
    $minutes = floor($timeSec / 60);
    $seconds = $timeSec % 60;
    return sprintf("%02d:%02d", $minutes, $seconds);
}

function parseDate($date) {
    if (!$date) return "-"; // return dash if empty

    $datetime = new DateTime($date); // create DateTime object

    return $datetime->format('d/m/Y à H:i'); // format 'dd/mm/yyyy at hh:mm'
}