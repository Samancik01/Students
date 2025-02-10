<?php
session_start(); // Sessiyani yoqish

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once "config/Database.php";
require_once "classes/Student.php";


$db = (new Database())->connect();
$student = new Student($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student->name = $_POST['name'];
    $student->email = $_POST['email'];
    $student->course = $_POST['course'];

    if ($student->create()) {
        // Flash xabarni o‘rnatish
        $_SESSION['success_message'] = "Talaba muvaffaqiyatli qo'shildi!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Bu email allaqachon mavjud! Iltimos, boshqa email kiriting.";
        header("Location: create.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talaba qo'shish</title>
</head>
<body>
    <h1>Talaba qo'shish</h1>
    <form method="POST" action="">
        <label>Ism:</label>
        <input type="text" name="name" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Kurs:</label>
        <input type="text" name="course" required>
        <br>
        <button type="submit">Qo'shish</button>
    </form>
</body>
</html>
