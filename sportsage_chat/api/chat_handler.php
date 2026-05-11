<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    http_response_code(403);
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$chatId = $data['chat_id'] ?? null;
$question = trim($data['question'] ?? '');

if (!$chatId || !$question) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Save user message
$stmt = $pdo->prepare('INSERT INTO messages (chat_id, sender, content) VALUES (?, "user", ?)');
$stmt->execute([$chatId, $question]);

// Call OpenAI API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, AI_API_ENDPOINT);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$payload = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful sports AI assistant."],
        ["role" => "user", "content" => $question]
    ],
    "temperature" => 0.7
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: ' . 'Bearer ' . AI_API_KEY
]);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    $aiResponse = "AI API error: " . curl_error($ch);
} else {
    $responseData = json_decode($result, true);
    $aiResponse = $responseData['choices'][0]['message']['content'] ?? 'No response from AI';
}

curl_close($ch);

// Save AI message
$stmt = $pdo->prepare('INSERT INTO messages (chat_id, sender, content) VALUES (?, "ai", ?)');
$stmt->execute([$chatId, $aiResponse]);

echo json_encode(['answer' => $aiResponse]);
