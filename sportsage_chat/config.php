<?php

$db_host = 'localhost';
$db_name = 'sportsage_chat';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (Exception $e) {
    die('DB connection failed: ' . $e->getMessage());
}


define('AI_API_KEY', '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'); // <-- Replace with your actual key
define('AI_API_ENDPOINT', 'https://api.openai.com/v1/chat/completions');


session_start();

function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

function is_admin() {
    return ($_SESSION['role'] ?? '') === 'admin';
}
?>
