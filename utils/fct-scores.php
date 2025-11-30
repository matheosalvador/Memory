<?php 
require_once 'database.php';
$pdo = getPDO();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ---------------------------------------------------------
   ENREGISTREMENT D'UN SCORE (POST JSON)
   Ajout du champ "data" pour les jeux non-Memory
--------------------------------------------------------- */
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

    $game_id    = (int)($input['game_id'] ?? 1);
    $difficulty = $input['difficulty'] ?? null;
    $time       = (int)($input['time'] ?? 0);
    $data       = $input['data'] ?? null; // JSON spécifique aux jeux

    if ($difficulty === null) {
        echo json_encode(['status' => 'ERROR', 'message' => 'Missing difficulty']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO score (user_id, game_id, difficulty, time, data, created_at)
            VALUES (:user_id, :game_id, :difficulty, :time, :data, NOW())
        ");

        $stmt->execute([
            ':user_id'    => $user_id,
            ':game_id'    => $game_id,
            ':difficulty' => $difficulty,
            ':time'       => $time,
            ':data'       => $data ? json_encode($data) : null
        ]);

        echo json_encode(['status' => 'OK', 'message' => 'Score saved', 'id' => $pdo->lastInsertId()]);
    } 
    catch (PDOException $e) {
        echo json_encode(['status' => 'ERROR', 'message' => 'DB error: ' . $e->getMessage()]);
    }

    exit;
}

/* ---------------------------------------------------------
   RÉCUPÉRATION DES SCORES (LISTE)
   Ajout filtres par pseudo et par jeu
--------------------------------------------------------- */
function getScores($game_id = null, $pseudo = '') {
    global $pdo;

    $baseQuery = "
        SELECT 
            s.id,
            s.user_id,
            s.game_id,
            s.difficulty,
            s.time,
            s.data,
            s.created_at,
            u.pseudo AS player_name,
            g.game_name
        FROM score s
        INNER JOIN main_user u ON s.user_id = u.id
        INNER JOIN game g ON s.game_id = g.id
    ";

    $conditions = [];
    $params = [];

    if ($game_id) {
        $conditions[] = "s.game_id = :game_id";
        $params['game_id'] = $game_id;
    }

    if ($pseudo) {
        $conditions[] = "u.pseudo LIKE :pseudo";
        $params['pseudo'] = "%$pseudo%";
    }

    if ($conditions) {
        $baseQuery .= " WHERE " . implode(" AND ", $conditions);
    }

    $baseQuery .= " ORDER BY s.created_at DESC";

    $stmt = $pdo->prepare($baseQuery);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ---------------------------------------------------------
   FORMATTAGE DES DIFFICULTÉS
--------------------------------------------------------- */
function getDifficultyLabel($difficulty) {
    return match($difficulty) {
        '1' => 'Easy',
        '2' => 'Medium',
        '3' => 'Hard',
        default => '-',
    };
}

/* ---------------------------------------------------------
   FORMATTAGE DU TEMPS POUR MEMORY
--------------------------------------------------------- */
function parseScore($score) {
    $timeSec = (int)$score;
    if ($timeSec <= 0) return "-";

    $minutes = floor($timeSec / 60);
    $seconds = $timeSec % 60;

    return sprintf("%02d:%02d", $minutes, $seconds);
}

/* ---------------------------------------------------------
   FORMATAGE DATE
--------------------------------------------------------- */
function parseDate($date) {
    if (!$date) return "-";
    return date("d/m/Y H:i", strtotime($date));
}

/* ---------------------------------------------------------
   INTERPRÉTATION DYNAMIQUE DU SCORE
   Memory → time
   Puissance 4 → winner/turns
   Jeu de l’oie → position/turns
--------------------------------------------------------- */
function parseScoreDisplay(array $score) {

    // Memory
    if (!empty($score['time']) && $score['time'] > 0 && $score['game_name'] === "Power Of Memory") {
        return parseScore($score['time']);
    }

    // JSON présent pour autres jeux
    if (!empty($score['data'])) {
        $data = json_decode($score['data'], true);

        if ($score['game_name'] === "Puissance 4") {
            return "Winner: " . ($data['winner'] ?? '?') .
                   " — Turns: " . ($data['turns'] ?? '?');
        }

        if ($score['game_name'] === "Jeu de l'oie") {
            return "Reached: " . ($data['position'] ?? '?') .
                   " — Turns: " . ($data['turns'] ?? '?');
        }
    }

    return "-";
}

/* ---------------------------------------------------------
   FONCTION DE FORMATAGE UTILISÉE DANS LA PAGE
--------------------------------------------------------- */
function formatScoreValue($gameName, array $score) {
    return parseScoreDisplay($score);
}
