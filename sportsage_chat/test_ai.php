<?php
require_once __DIR__ . '/config.php';

$question = "Who won the last FIFA World Cup?";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, AI_API_ENDPOINT);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "model"=>"gpt-3.5-turbo",
    "messages"=>[["role"=>"user","content"=>$question]]
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . AI_API_KEY
]);
$result = curl_exec($ch);
curl_close($ch);

var_dump(json_decode($result, true));
