<?php

require_once __DIR__ . '/../config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$email || !$password) {
        $err = 'Please fill in all fields.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        try {
            $stmt->execute([$username, $email, $hash]);
            header('Location: login.php');
            exit;
        } catch (Exception $e) {
            $err = 'Registration failed: ' . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SportsAge - Register</title>

<style>
    body {
        background: #0d1117;
        color: #c9d1d9;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .register-box {
        background: #161b22;
        padding: 35px;
        width: 330px;
        border-radius: 12px;
        box-shadow: 0 0 15px #000;
        text-align: center;
    }

    h2 {
        color: #58a6ff;
        margin-bottom: 20px;
    }

    input {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #30363d;
        background: #0d1117;
        color: #c9d1d9;
        font-size: 15px;
    }

    input:focus {
        outline: none;
        border-color: #58a6ff;
    }

    button {
        width: 95%;
        padding: 12px;
        background: #238636;
        border: none;
        border-radius: 6px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background: #2ea043;
    }

    a {
        color: #58a6ff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .error {
        background: #ff4d4f22;
        color: #ff6b6b;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        border: 1px solid #ff6b6b55;
    }
</style>
</head>

<body>

<div class="register-box">

    <h2>SportsAge - Register</h2>

    <?php if(!empty($err)): ?>
        <div class="error"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post">
        <input name="username" placeholder="Username">
        <input name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button>Register</button>
    </form>

    <p style="margin-top: 15px;">
        <a href="login.php">Already have an account? Login</a>
    </p>

</div>

</body>
</html>
