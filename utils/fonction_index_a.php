<?php
include 'database.php';

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

