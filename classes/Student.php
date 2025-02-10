<?php
class Student {
    private $conn;
    private $table = "students";

    public $id;
    public $name;
    public $email;
    public $course;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Talaba qo'shish
    public function create() {
        // Email mavjudligini tekshirish
        $checkQuery = "SELECT COUNT(*) as count FROM students WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(":email", $this->email);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result['count'] > 0) {
            // Email mavjud, foydalanuvchini ogohlantirish
            echo "Bu email allaqachon mavjud! Boshqa email kiriting.";
            return false;
        }
    
        // Agar email yo'q bo'lsa, ma'lumotni qo'shish
        $query = "INSERT INTO students (name, email, course) VALUES (:name, :email, :course)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":course", $this->course);
    
        return $stmt->execute();
    }
    
        // Talabalar ro'yxatini olish
        public function read() {
            $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            return $stmt;
        }

    // Talaba ma'lumotlarini yangilash
    public function update() {
        $query = "UPDATE " . $this->table . " SET name = :name, email = :email, course = :course WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":course", $this->course);

        return $stmt->execute();
    }

    // Talabani o'chirish
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}