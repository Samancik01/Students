<?php
require_once "config/Database.php";
require_once "classes/Student.php";

session_start();

$db = (new Database())->connect();
$student = new Student($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student->id = $_POST['id'];
    $student->name = $_POST['name'];
    $student->email = $_POST['email'];
    $student->course = $_POST['course'];

    if ($student->update()) {
        $_SESSION['success_message'] = "Talaba ma'lumotlari muvaffaqiyatli tahrirlandi!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Talaba ma'lumotlarini tahrirlashda xatolik yuz berdi.";
        header("Location: edit.php?id=" . $student->id);
        exit;
    }
}

// Ma'lumotlar bazasi va talaba obyektini yaratish
$db = (new Database())->connect();
$student = new Student($db);

// URL orqali kelgan talaba ID sini olish
if (isset($_GET['id'])) {
    $student->id = $_GET['id'];

    // Talaba ma'lumotlarini olish
    $stmt = $student->read();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $student->name = $result['name'];
        $student->email = $result['email'];
        $student->course = $result['course'];
    } else {
        echo "Talaba topilmadi!";
        exit;
    }
}

// Tahrirlash so'rovi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student->id = $_POST['id'];
    $student->name = $_POST['name'];
    $student->email = $_POST['email'];
    $student->course = $_POST['course'];

    if ($student->update()) {
        header("Location: index.php");
    } else {
        echo "Xatolik yuz berdi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talaba ma'lumotlarini tahrirlash</title>
</head>
<body>
    <h1>Talaba ma'lumotlarini tahrirlash</h1>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $student->id ?>">
        <label>Ism:</label>
        <input type="text" name="name" value="<?= $student->name ?>" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $student->email ?>" required>
        <br>
        <label>Kurs:</label>
        <input type="text" name="course" value="<?= $student->course ?>" required>
        <br>
        <button type="submit">Yangilash</button>
    </form>
</body>
</html>
