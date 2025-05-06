<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === '1234') {
        $_SESSION['logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Нууц үг эсвэл хэрэглэгч буруу байна!";
    }
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Нэвтрэх</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Админ нэвтрэх</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Хэрэглэгчийн нэр:</label>
        <input type="text" name="username" required>

        <label>Нууц үг:</label>
        <input type="password" name="password" required>

        <button type="submit">Нэвтрэх</button>
    </form>
</div>

</body>
</html>
