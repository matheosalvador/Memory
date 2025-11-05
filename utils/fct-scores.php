<?php 
require_once '../../utils/database.php';

function getScores() {
    $pdo = getPDO();
    $pseudo = $_GET['pseudo'] ?? '';
    if ($pseudo) {
        $stmt = $pdo->prepare("
            SELECT s.id, u.pseudo AS player_name, g.game_name, s.difficulty, s.time, s.created_at
            FROM score s
            INNER JOIN main_user u ON s.user_id = u.id
            INNER JOIN game g ON s.game_id = g.id
            WHERE u.pseudo LIKE :pseudo
            ORDER BY s.time ASC
        ");
        $stmt->execute(['pseudo' => "%$pseudo%"]);
    } else {
        $stmt = $pdo->query("
            SELECT s.id, u.pseudo AS player_name, g.game_name, s.difficulty, s.time, s.created_at
            FROM score s
            INNER JOIN main_user u ON s.user_id = u.id
            INNER JOIN game g ON s.game_id = g.id
            ORDER BY s.time ASC
        ");
    }

    return $stmt->fetchAll();
}

function getDifficultyLabel($difficulty) {
    return match($difficulty) {
        '1' => 'easy',
        '2' => 'medium',
        '3' => 'hard',
        default => 'Unknown'
    };
}

function parseScore($score) {
    $timeSec = (int)$score;
    $minutes = floor($timeSec / 60);
    $seconds = $timeSec % 60;
    return sprintf("%02d:%02d", $minutes, $seconds);
}

function parseDate($date) {
    if (!$date) return "-";

    $datetime = new DateTime($date);

    return $datetime->format('d/m/Y à H:i');
}