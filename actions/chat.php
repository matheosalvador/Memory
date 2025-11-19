<?php
require_once __DIR__ . '/../utils/database.php';
session_start();

$pdo = getPDO();

$action = $_GET['action'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$gameId = 1;

// LOAD messages
if ($action === "load") {

    $sql = "
        SELECT 
            m.id,
            m.message,
            m.user_id,
            m.created_at,
            u.pseudo
        FROM message m
        JOIN main_user u ON u.id = m.user_id
        WHERE m.game_id = ?
        AND m.created_at >= NOW() - INTERVAL 24 HOUR
        ORDER BY m.created_at ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$gameId]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}


// SEND message
if ($action === "send") {

    if (!isset($_POST['message']) || trim($_POST['message']) === "") {
        echo json_encode(['status' => 'empty']);
        exit;
    }

    $msg = trim($_POST['message']);

    $sql = "INSERT INTO message (game_id, user_id, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$gameId, $userId, $msg])) {
        echo json_encode(['status' => 'OK']);
    } else {
        echo json_encode([
            'status' => 'error',
            'info' => $stmt->errorInfo()[2]
        ]);
    }
    exit;
}

echo json_encode(['success' => 'No action']);
//Message_privée 
