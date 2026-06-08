<?php
// SahaTestleri.php
require_once 'Database.php';

class SahaTestleri {
    private $conn;
    private $table_name = "saha_testleri";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Read (Okuma) İşlemi: Testleri ve testi giren kişinin bilgilerini JOIN ile çekme
    public function tumTestleriGetir() {
        // saha_testleri tablosu ile takim_uyeleri tablosunu raportor_id üzerinden bağlıyoruz
        $query = "SELECT 
                    st.id, 
                    st.test_adi, 
                    st.ana_gorev, 
                    st.alt_gorev, 
                    st.hedef_sinyal_tipi, 
                    st.genel_sonuc, 
                    tu.ad_soyad AS raportor_adi,
                    tu.uzmanlik_alani
                  FROM 
                    " . $this->table_name . " st
                  LEFT JOIN 
                    takim_uyeleri tu ON st.raportor_id = tu.id
                  ORDER BY 
                    st.baslangic_tarihi DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    
    // Güvenlik kuralı: Yeni kullanıcı eklerken şifreyi Hashleme
    public function kullaniciEkle($kullanici_adi, $sifre, $ad_soyad, $uzmanlik) {
        $query = "INSERT INTO takim_uyeleri (kullanici_adi, sifre, ad_soyad, uzmanlik_alani) 
                  VALUES (:kadi, :sifre, :ad, :uzmanlik)";
                  
        $stmt = $this->conn->prepare($query);
        
        // Hocanın zorunlu tuttuğu password_hash fonksiyonu
        $hashli_sifre = password_hash($sifre, PASSWORD_BCRYPT);
        
        $stmt->bindParam(':kadi', $kullanici_adi);
        $stmt->bindParam(':sifre', $hashli_sifre);
        $stmt->bindParam(':ad', $ad_soyad);
        $stmt->bindParam(':uzmanlik', $uzmanlik);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    
    // CREATE: Yeni test ekleme
    public function testEkle($test_adi, $ana_gorev, $alt_gorev, $hedef_sinyal, $baslangic, $sonuc, $raportor_id) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (test_adi, ana_gorev, alt_gorev, hedef_sinyal_tipi, baslangic_tarihi, genel_sonuc, raportor_id) 
                  VALUES (:test_adi, :ana_gorev, :alt_gorev, :hedef_sinyal, :baslangic, :sonuc, :raportor_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':test_adi', $test_adi);
        $stmt->bindParam(':ana_gorev', $ana_gorev);
        $stmt->bindParam(':alt_gorev', $alt_gorev);
        $stmt->bindParam(':hedef_sinyal', $hedef_sinyal);
        $stmt->bindParam(':baslangic', $baslangic);
        $stmt->bindParam(':sonuc', $sonuc);
        $stmt->bindParam(':raportor_id', $raportor_id);
        return $stmt->execute();
    }

    // READ (Tekil): Düzenleme formu için tek bir testi getirme
    public function testGetir($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // UPDATE: Mevcut testi güncelleme
    public function testGuncelle($id, $test_adi, $ana_gorev, $alt_gorev, $hedef_sinyal, $sonuc) {
        $query = "UPDATE " . $this->table_name . " 
                  SET test_adi = :test_adi, ana_gorev = :ana_gorev, alt_gorev = :alt_gorev, 
                      hedef_sinyal_tipi = :hedef_sinyal, genel_sonuc = :sonuc 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':test_adi', $test_adi);
        $stmt->bindParam(':ana_gorev', $ana_gorev);
        $stmt->bindParam(':alt_gorev', $alt_gorev);
        $stmt->bindParam(':hedef_sinyal', $hedef_sinyal);
        $stmt->bindParam(':sonuc', $sonuc);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // DELETE: Testi silme
    public function testSil($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    }
}
?>