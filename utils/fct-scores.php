<?php 
require_once 'database.php'; // include database connction
$pdo = getPDO();// get pdo database connection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// enregistrement post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        echo json_encode(['status' => 'ERROR', 'message' => 'Invalid JSON']);
        exit;
    }

    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo json_encode(['status' => 'ERROR', 'message' => 'User not logged in']);
        exit;
    }

    $game_id = (int)($input['game_id'] ?? 1);
    $difficulty = $input['difficulty'] ?? null;
    $score = (int)($input['time'] ?? 0);

    if ($difficulty === null) {
        echo json_encode(['status' => 'ERROR', 'message' => 'Missing difficulty']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO score (user_id, game_id, difficulty, time, created_at)
            VALUES (:user_id, :game_id, :difficulty, :time, NOW())
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':game_id' => $game_id,
            ':difficulty' => $difficulty,
            ':time' => $score
        ]);

        echo json_encode(['status' => 'OK', 'message' => 'Score saved', 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'ERROR', 'message' => 'DB error: ' . $e->getMessage()]);
    }
    exit;
}

function getScores() {
    global $pdo;
    $pseudo = $_GET['pseudo'] ?? ''; // pseudo from url
    if ($pseudo) {
        // if exist, we get sql request from most score table
        $stmt = $pdo->prepare("
            SELECT s.id, s.user_id, u.pseudo AS player_name, g.game_name, s.difficulty, s.time, s.created_at
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
            SELECT s.id, s.user_id, u.pseudo AS player_name, g.game_name, s.difficulty, s.time, s.created_at
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