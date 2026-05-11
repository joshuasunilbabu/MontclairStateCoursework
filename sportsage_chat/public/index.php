<?php
require_once __DIR__ . '/../config.php';

if (!is_logged_in()) {
    header('Location: ../auth/login.php');
    exit;
}

$userId = current_user_id();
$username = $_SESSION['username'] ?? 'User';

$stmt = $pdo->prepare('SELECT * FROM chats WHERE user_id = ? ORDER BY created_at DESC LIMIT 1');
$stmt->execute([$userId]);
$chat = $stmt->fetch();

if (!$chat) {
    $stmt = $pdo->prepare('INSERT INTO chats (user_id, title) VALUES (?, ?)');
    $stmt->execute([$userId, 'My First Chat']);
    $chatId = $pdo->lastInsertId();
    $chat = ['id' => $chatId, 'title' => 'My First Chat'];
} else {
    $chatId = $chat['id'];
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SportsAge AI Chat</title>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #0b0f19;
        font-family: Arial, sans-serif;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .chat-wrapper {
        width: 90%;
        max-width: 900px;
        height: 90vh;
        background: #111827;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        padding: 0 0 15px 0;
    }

    .home-btn {
        display: inline-block;
        margin: 15px auto 0 auto;
        padding: 10px 18px;
        background: #007bff;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        font-family: Arial, sans-serif;
        text-align: center;
        width: fit-content;
    }
    .home-btn:hover {
        background: #0056b3;
    }

    .chat-header {
        padding: 18px;
        background: #1f2937;
        font-size: 20px;
        font-weight: bold;
        border-bottom: 1px solid #334155;
        text-align: center;
    }

    #messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }

    .msg-user, .msg-ai {
        padding: 12px 15px;
        max-width: 75%;
        margin-bottom: 12px;
        border-radius: 10px;
        line-height: 1.4;
        white-space: pre-wrap;
    }
    .msg-user {
        background: #1d4ed8;
        align-self: flex-end;
    }
    .msg-ai {
        background: #374151;
        align-self: flex-start;
    }

    .chat-input {
        display: flex;
        border-top: 1px solid #334155;
        padding: 12px;
        background: #1f2937;
    }

    #question {
        flex: 1;
        resize: none;
        padding: 10px;
        border-radius: 8px;
        border: none;
        outline: none;
        background: #111827;
        color: white;
        height: 60px;
    }

    .send-btn {
        margin-left: 10px;
        padding: 10px 20px;
        background: #2563eb;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        color: white;
    }

    .send-btn:hover {
        background: #1d4ed8;
    }

    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 10px;
    }
</style>
</head>

<body>

<div class="chat-wrapper">

    <!-- HOME BUTTON -->
    <a href="../user/dashboard.php" class="home-btn">← Home</a>

    <div class="chat-header">
        SportsAge AI Chat — <?= htmlspecialchars($chat["title"]) ?>
    </div>

    <div id="messages"></div>

    <form id="askForm" class="chat-input">
        <textarea id="question" placeholder="Ask anything about sports…"></textarea>
        <button class="send-btn" type="submit">Send</button>
    </form>

</div>

<script>
const chatId = <?= json_encode((int)$chatId) ?>;

async function loadMessages() {
    const res = await fetch('../api/get_messages.php?chat_id=' + chatId);
    const box = document.getElementById('messages');
    const data = await res.json();

    box.innerHTML = '';

    data.forEach(m => {
        const div = document.createElement('div');
        div.className = m.sender === 'user' ? 'msg-user' : 'msg-ai';
        div.textContent = m.content;
        box.appendChild(div);
    });

    box.scrollTop = box.scrollHeight;
}

document.getElementById('askForm').addEventListener('submit', async e => {
    e.preventDefault();

    const q = document.getElementById('question').value.trim();
    if (!q) return;

    await fetch('../api/chat_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ chat_id: chatId, question: q })
    });

    document.getElementById('question').value = '';
    await loadMessages();
});

loadMessages();
</script>

</body>
</html>
