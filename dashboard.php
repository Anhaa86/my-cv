<?php
session_start();
include 'config.php';

// Хэрэв админ нэвтрээгүй бол эргэж нэвтрэх хуудас руу илгээх
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Цэсийг нэмэх
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_name'], $_POST['menu_content'])) {
    $menu_name = $_POST['menu_name'];
    $menu_content = $_POST['menu_content'];

    // SQL руу цэс нэмэх
    $stmt = $pdo->prepare("INSERT INTO menus (name, content) VALUES (?, ?)");
    $stmt->execute([$menu_name, $menu_content]);
    $success = "Цэс амжилттай нэмэгдлээ!";
}

// Цэсийг засварлах
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $menu_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
    $stmt->execute([$menu_id]);
    $menu = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_name'], $_POST['menu_content'])) {
        $menu_name = $_POST['menu_name'];
        $menu_content = $_POST['menu_content'];

        // SQL руу засвар хийх
        $stmt = $pdo->prepare("UPDATE menus SET name = ?, content = ? WHERE id = ?");
        $stmt->execute([$menu_name, $menu_content, $menu_id]);
        header('Location: dashboard.php');
        exit;
    }
}

// Цэсийг устгах
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $menu_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM menus WHERE id = ?");
    $stmt->execute([$menu_id]);
    header('Location: dashboard.php');
    exit;
}

// Цэсүүдийг авах
$stmt = $pdo->query("SELECT * FROM menus");
$menus = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Админ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 40px;
        }

        input[type="text"],
        textarea {
            width: 95%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            padding: 12px 20px;
            background-color: #007BFF;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .menu-list {
            margin-top: 40px;
        }

        .menu-item {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .menu-item h3 {
            margin: 0;
        }

        .menu-item p {
            margin: 5px 0;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
<div style="text-align: right; margin-bottom: 20px;">
    Сайн байна уу, Админ! 
    <a href="logout.php" style="color: red; font-weight: bold; text-decoration: none; margin-left: 15px;">🚪 Гарах</a>
</div>

<div class="container">
    <h2>Админ</h2>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <h3>Цэс Нэмэх</h3>
    <form method="POST">
        <label for="menu_name">Цэсний нэр:</label>
        <input type="text" id="menu_name" name="menu_name" required>

        <label for="menu_content">Цэсний агуулга:</label>
        <textarea id="menu_content" name="menu_content" rows="4" required></textarea>

        <button type="submit">Нэмэх</button>
    </form>

    <h3>Цэсүүд</h3>
    <div class="menu-list">
        <?php foreach ($menus as $menu): ?>
            <div class="menu-item">
                <h3><?= htmlspecialchars($menu['name']) ?></h3>
                <p><?= htmlspecialchars($menu['content']) ?></p>

                <!-- Засварлах холбоос -->
                <a href="dashboard.php?edit=true&id=<?= $menu['id'] ?>">Засварлах</a> |
                
                <!-- Устгах холбоос -->
                <a href="dashboard.php?delete=true&id=<?= $menu['id'] ?>" onclick="return confirm('Та энэ цэсийг устгахдаа итгэлтэй байна уу?')">Устгах</a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_GET['edit']) && isset($menu)): ?>
        <h3>Цэс Засварлах</h3>
        <form method="POST">
            <label for="menu_name">Цэсний нэр:</label>
            <input type="text" id="menu_name" name="menu_name" value="<?= htmlspecialchars($menu['name']) ?>" required>

            <label for="menu_content">Цэсний агуулга:</label>
            <textarea id="menu_content" name="menu_content" rows="4" required><?= htmlspecialchars($menu['content']) ?></textarea>

            <button type="submit">Засварлах</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
