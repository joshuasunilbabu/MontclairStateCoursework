<?php

require_once __DIR__ . '/../config.php';

if (!is_logged_in()) {
    header('Location: ../auth/login.php');
    exit;
}

$userId = current_user_id();
$username = $_SESSION['username'] ?? '';

//Fetch chats
$stmt = $pdo->prepare('SELECT * FROM chats WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$userId]);
$chats = $stmt->fetchAll();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>SportsAge Dashboard</title>

    <style>
        body {
            background: #0d1117;
            color: #c9d1d9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 900px;
            margin: auto;
            background: #161b22;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px #000;
        }

        h2 {
            color: #58a6ff;
            margin-bottom: 10px;
            font-size: 28px;
        }

        h3 {
            margin-top: 30px;
            color: #58a6ff;
        }

        .welcome {
            margin-bottom: 20px;
            font-size: 18px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background: #1f242d;
            margin: 10px 0;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
        }

        a {
            color: #58a6ff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer-links {
            margin-top: 30px;
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            padding: 10px 15px;
            background: #238636;
            color: white !important;
            border-radius: 6px;
        }

        .footer-links a:hover {
            background: #2ea043;
        }
    </style>
</head>

<body>
<div class="dashboard-container">

    <h2>SportsAge - User Dashboard</h2>
    <p class="welcome">Welcome, <?= htmlspecialchars($username) ?>!</p>

    <h3>Your Chats</h3>

    <?php if (!empty($chats)) : ?>
        <ul>
            <?php foreach ($chats as $c): ?>
                <li>
                    <a href="../public/index.php?chat_id=<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['title']) ?>
                    </a>
                    <span><?= $c['created_at'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no chats yet.  
            <a href="../public/index.php">Start a chat</a>
        </p>
    <?php endif; ?>

    <div class="footer-links">
        <a href="../public/index.php">Back to Chat</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

</div>
</body>
</html>
