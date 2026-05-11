<?php

require_once __DIR__ . '/../config.php';

if (!is_logged_in() || !is_admin()) {
    header('Location: ../auth/login.php');
    exit;
}

//Fetch users
$users = $pdo->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll();

$recent_chats = $pdo->query('
    SELECT chats.*, users.username 
    FROM chats 
    JOIN users ON chats.user_id = users.id 
    ORDER BY chats.created_at DESC LIMIT 20
')->fetchAll();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>SportsAge Admin Dashboard</title>

    <style>
        body {
            background: #0d1117;
            color: #c9d1d9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .admin-container {
            max-width: 1100px;
            margin: auto;
            background: #161b22;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px #000;
        }

        h2 {
            color: #58a6ff;
            margin-bottom: 15px;
            font-size: 32px;
            text-align: center;
        }

        h3 {
            margin-top: 40px;
            color: #58a6ff;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #1f242d;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #30363d;
        }

        table th {
            background: #21262d;
            color: #58a6ff;
            text-align: left;
        }

        table tr:hover td {
            background: #2d333b;
        }

        .chat-list {
            list-style: none;
            padding-left: 0;
            margin-top: 15px;
        }

        .chat-list li {
            background: #1f242d;
            margin: 8px 0;
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
            padding: 12px 18px;
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
<div class="admin-container">

    <h2>SportsAge - Admin Dashboard</h2>

    <h3>Users</h3>
    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created</th>
        </tr>

        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
            <td><?= $u['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Recent Chats</h3>
    <ul class="chat-list">
        <?php foreach ($recent_chats as $c): ?>
        <li>
            <span><?= htmlspecialchars($c['title']) ?></span>
            <span>by <?= htmlspecialchars($c['username']) ?> (<?= $c['created_at'] ?>)</span>
        </li>
        <?php endforeach; ?>
    </ul>

    <div class="footer-links">
        <a href="../public/index.php">Open SportsAge Chat</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

</div>
</body>
</html>
