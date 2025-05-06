<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}
include 'config.php';

// Цэс нэмэх
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['menu_name'];
    $stmt = $pdo->prepare("INSERT INTO menus (name) VALUES (?)");
    $stmt->execute([$name]);
}

// Цэс устгах
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM menus WHERE id = ?");
    $stmt->execute([$id]);
}
?>

<h2>Цэс удирдах</h2>
<form method="POST">
    <input type="text" name="menu_name" required placeholder="Шинэ цэсний нэр">
    <button type="submit">Нэмэх</button>
</form>

<ul>
<?php
$stmt = $pdo->query("SELECT * FROM menus");
while ($row = $stmt->fetch()) {
    echo "<li>{$row['name']} <a href='?delete={$row['id']}'>[Устгах]</a></li>";
}
?>
</ul>
<a href="dashboard.php">Буцах</a>
