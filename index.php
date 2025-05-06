<?php
include 'config.php';

// URL параметрээс id авах
$menu_id = isset($_GET['menu']) ? (int)$_GET['menu'] : 0;

// Хэрэв menu id өгөгдсөн бол мэдээллийг авч ирэх
$content = '';
if ($menu_id) {
    $stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
    $stmt->execute([$menu_id]);
    $menu = $stmt->fetch();
    if ($menu) {
        $content = "<h2>{$menu['name']}</h2><p>{$menu['content']}</p>";
    } else {
        $content = "<p>Цэс олдсонгүй.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>CV</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Шинэбаяр Анхбаяр</h1>
        <nav>
            <ul>
                <?php
                $stmt = $pdo->query("SELECT * FROM menus");
                while ($row = $stmt->fetch()) {
                    echo "<li><a href='index.php?menu={$row['id']}'>{$row['name']}</a></li>";
                }
                ?>
                <li><a href="login.php">Нэвтрэх</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($menu_id): ?>
            <section>
                <?= $content ?>
            </section>
        <?php else: ?>
            <section>
                <h2>Миний танилцуулга хуудсанд тавтай морил</h2>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2025 Бүх эрх хуулиар хамгаалагдсан.</p>
    </footer>
</body>
</html>
