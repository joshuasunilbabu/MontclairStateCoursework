<?php
require_once __DIR__ . '/../config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $err = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: ../user/dashboard.php');
            }
            exit;
        } else {
            $err = 'Invalid username/email or password.';
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>SportsAge Login</title>

    <style>
        /* AUTH PAGE STYLES */
        body {
            background: #0d1117;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .auth-container {
            width: 350px;
            background: #161b22;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px #000;
            text-align: center;
        }

        .auth-title {
            color: #58a6ff;
            margin-bottom: 20px;
            font-size: 26px;
        }

        .auth-error {
            background: #da3633;
            padding: 10px;
            border-radius: 6px;
            color: white;
            margin-bottom: 15px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
        }

        .auth-input {
            padding: 12px;
            margin: 10px 0;
            border: none;
            background: #1f242d;
            color: #d9d9d9;
            border-radius: 8px;
            font-size: 16px;
        }

        .auth-input:focus {
            outline: 2px solid #58a6ff;
        }

        .auth-button {
            background: #238636;
            border: none;
            padding: 12px;
            color: white;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        .auth-button:hover {
            background: #2ea043;
        }

        .auth-link-text {
            margin-top: 20px;
            color: #c9d1d9;
        }

        .auth-link {
            color: #58a6ff;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
<div class="auth-container">

    <h2 class="auth-title">SportsAge Login</h2>

    <?php if (!empty($err)) : ?>
        <p class="auth-error"><?= htmlspecialchars($err) ?></p>
    <?php endif; ?>

    <form method="post" class="auth-form">
        <input class="auth-input" name="username" placeholder="username or email">
        <input class="auth-input" type="password" name="password" placeholder="password">
        <button class="auth-button">Login</button>
    </form>

    <p class="auth-link-text">
        Don't have an account?
        <a class="auth-link" href="register.php">Register here</a>
    </p>

</div>
</body>
</html>
