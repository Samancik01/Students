<?php
require_once "config/Database.php";
require_once "classes/Student.php";

session_start();

$db = (new Database())->connect();
$student = new Student($db);

if (isset($_GET['id'])) {
    $student->id = $_GET['id'];

    if ($student->delete()) {
        $_SESSION['success_message'] = "Talaba muvaffaqiyatli o'chirildi!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Talabani o'chirishda xatolik yuz berdi.";
        header("Location: index.php");
        exit;
    }
}

// Ma'lumotlar bazasi va talaba obyektini yaratish
$db = (new Database())->connect();
$student = new Student($db);

// URL orqali kelgan talaba ID sini olish
if (isset($_GET['id'])) {
    $student->id = $_GET['id'];

    // Talabani o'chirish
    if ($student->delete()) {
        header("Location: index.php");
    } else {
        echo "Xatolik yuz berdi! Talaba o'chirilmadi.";
    }
} else {
    echo "Talaba ID topilmadi!";
}