<?php
// Envanter.php
require_once 'Database.php';

class Envanter {
    private $conn;
    private $table_name = "envanter_ve_moduller";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // READ: Tüm donanımları listele
    public function tumEnvanteriGetir() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY eklenme_tarihi DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE: Yeni modül/donanım ekle
    public function modulEkle($modul_adi, $kategori, $stok_durumu) {
        $query = "INSERT INTO " . $this->table_name . " (modul_adi, kategori, stok_durumu) 
                  VALUES (:modul_adi, :kategori, :stok_durumu)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':modul_adi', $modul_adi);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':stok_durumu', $stok_durumu);
        return $stmt->execute();
    }

    // UPDATE: Sadece stok durumunu güncelle (Örn: "Testte" -> "Arızalı")
    public function durumGuncelle($id, $yeni_durum) {
        $query = "UPDATE " . $this->table_name . " SET stok_durumu = :yeni_durum WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':yeni_durum', $yeni_durum);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // DELETE: Envanterden sil
    public function modulSil($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>