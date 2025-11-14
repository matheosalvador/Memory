<?php
require_once __DIR__ . '/database.php';

function getGamesPlayed() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM score");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['total'] : 0;
}

function getRecordByDifficulty($difficulty) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT r.record_time, r.player_id, u.pseudo
        FROM records r
        LEFT JOIN main_user u ON r.player_id = u.id
        WHERE r.difficulty = :difficulty
    ");
    $stmt->execute(['difficulty' => $difficulty]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    return $record ? $record : ['record_time' => 0, 'player_id' => null, 'pseudo' => null];
}

function getRecordsBeatenToday($difficulty) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS count
        FROM record_history
        WHERE difficulty = :difficulty AND beaten_at = CURDATE()
    ");
    $stmt->execute(['difficulty' => $difficulty]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['count'] : 0;
}

function getTotalPlayers() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM main_user");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['total'] : 0;
}

function getPlayersOnline() {
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT COUNT(*) AS online 
        FROM main_user 
        WHERE last_activity >= NOW() - INTERVAL 15 MINUTE
    ");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['online'] : 0;
}
