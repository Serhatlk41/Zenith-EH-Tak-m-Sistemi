<?php
// Database.php
require_once 'config.php';

class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Karakter setini utf8mb4 yaparak Türkçe karakter sorunlarının önüne geçiyoruz
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            
            // Hata fırlatma modunu aktif ediyoruz (Geliştirme aşamasında hayat kurtarır)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Verilerin PHP'ye array yerine doğrudan obje olarak gelmesini sağlıyoruz
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            
        } catch(PDOException $exception) {
            echo "Veritabanı Bağlantı Hatası: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>