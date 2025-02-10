<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talabalar ro‘yxati</title>
    <script>
    function confirmDelete() {
        return confirm("Siz haqiqatan ham ushbu talabani o'chirmoqchimisiz?");
    }
    </script>
    <style>
/* Flash xabarlar uchun umumiy uslub */
.flash-success, .flash-error {
    width: 100%;
    max-width: 500px;
    margin: 20px auto;
    text-align: center;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.8s ease-out;
}

.flash-success {
    background-color: #e7fbe7;
    color: green;
    border: 1px solid green;
}

.flash-error {
    background-color: #fbe7e7;
    color: red;
    border: 1px solid red;
}

/* Animatsiya: xabarni borgan sari kamaytirish */
.flash-disappear {
    height: 0; /* Balndlikni yo'q qilish */
    padding: 0; /* Ichki bo'shliqni yo'q qilish */
    opacity: 0; /* Rangni yo'q qilish */
    margin: 0; /* Tashqi bo'shliqni yo'q qilish */
    transition: all 1s ease-out; /* Hammasi birgalikda */
}

    </style>
</head>
<body>
    <h1>Talabalar ro‘yxati</h1>
     <!-- Talaba qo'shish tugmasi -->
     <a href="create.php" style="display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Talaba qo'shish</a>
    <?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo "<p id='flash-message' class='flash-success'>{$_SESSION['success_message']}</p>";
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo "<p id='flash-message' class='flash-error'>{$_SESSION['error_message']}</p>";
    unset($_SESSION['error_message']);
}
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ismi</th>
                <th>Email</th>
                <th>Kurs</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "config/Database.php";
            require_once "classes/Student.php";

            $db = (new Database())->connect();
            $student = new Student($db);

            $students = $student->read(); // Barcha talabalarni olish funksiyasi

            foreach ($students as $row) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['course']}</td>";
                echo "<td>";
                echo "<a href='update.php?id={$row['id']}'>Tahrirlash</a> | ";
                echo "<a href='delete.php?id={$row['id']}' onclick='return confirmDelete();'>O'chirish</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.classList.add('flash-disappear'); // Animatsiya klassini qo'shish
            setTimeout(() => flashMessage.remove(), 1000); // DOMdan olib tashlash
        }
    }, 3000); // Xabarni 3 soniyadan keyin boshlash
    // Tahrirlash tugmasi
    const updateLinks = document.querySelectorAll('a[href="update.php"]');
  updateLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      event.preventDefault(); // Предотвращаем переход по ссылке
      const studentId = this.dataset.id;
      window.location.href = `update.php?id=${studentId}`;
    });
  });
  // O'chirish tugmasi
  const deleteLinks = document.querySelectorAll('a[href="delete.php"]');
  deleteLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      event.preventDefault(); // Предотвращаем переход по ссылке
      const studentId = this.dataset.id;
      if (confirmDelete()) {
        window.location.href = `delete.php?id=${studentId}`;
      }
    });
  });
</script>


</body>
</html>