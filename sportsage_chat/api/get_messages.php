<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    http_response_code(403);
    echo json_encode([]);
    exit;
}

$chatId = $_GET['chat_id'] ?? 0;

$stmt = $pdo->prepare('SELECT * FROM messages WHERE chat_id = ? ORDER BY created_at ASC');
$stmt->execute([$chatId]);
$messages = $stmt->fetchAll();

echo json_encode($messages);
