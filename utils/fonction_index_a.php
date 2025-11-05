<?php
require_once __DIR__ . '/database.php';

function getGamesPlayed() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM score");
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

function getRecordTime() {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT time AS record FROM score ORDER BY time ASC LIMIT 1");
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC)['record'];
    return $record ? $record : 0;
}

function updateRecord($difficulty, $newTime, $playerId) {
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT record_time FROM records WHERE difficulty = :difficulty");
    $stmt->execute(['difficulty' => $difficulty]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $isNewRecord = false;

    if (!$record) {
        $stmt2 = $pdo->prepare("
            INSERT INTO records (difficulty, record_time, player_id)
            VALUES (:difficulty, :record_time, :player_id)
        ");
        $stmt2->execute([
            'difficulty' => $difficulty,
            'record_time' => $newTime,
            'player_id' => $playerId
        ]);
        $isNewRecord = true;
    } elseif ($newTime < $record['record_time']) {
        $stmt2 = $pdo->prepare("
            UPDATE records
            SET record_time = :record_time, player_id = :player_id, updated_at = CURRENT_TIMESTAMP
            WHERE difficulty = :difficulty
        ");
        $stmt2->execute([
            'record_time' => $newTime,
            'player_id' => $playerId,
            'difficulty' => $difficulty
        ]);
        $isNewRecord = true;
    }

    if ($isNewRecord) {
        $stmt3 = $pdo->prepare("
            INSERT INTO record_history (difficulty, record_time, player_id, beaten_at)
            VALUES (:difficulty, :record_time, :player_id, CURDATE())
        ");
        $stmt3->execute([
            'difficulty' => $difficulty,
            'record_time' => $newTime,
            'player_id' => $playerId
        ]);
    }
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
// Compte le nombre total de joueurs inscrits
function getTotalPlayers() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM main_user");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['total'] : 0;
}
