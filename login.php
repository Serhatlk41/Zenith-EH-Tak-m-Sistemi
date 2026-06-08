<?php
session_start();
require_once 'Database.php';

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $conn = $db->getConnection();
    
    $kullanici_adi = $_POST['kullanici_adi'];
    $girilen_sifre = $_POST['sifre'];
    
    // Kullanıcıyı veritabanında bul
    $query = "SELECT id, kullanici_adi, sifre, ad_soyad, uzmanlik_alani FROM takim_uyeleri WHERE kullanici_adi = :kadi LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':kadi', $kullanici_adi);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        // Hocanın kuralı: password_verify ile hashlenmiş şifreyi kontrol et
        if (password_verify($girilen_sifre, $row->sifre)) {
            // Oturum değişkenlerini ata
            $_SESSION['uye_id'] = $row->id;
            $_SESSION['ad_soyad'] = $row->ad_soyad;
            $_SESSION['uzmanlik'] = $row->uzmanlik_alani;
            
            header("Location: index.php");
            exit;
        } else {
            $hata = "Şifre hatalı!";
        }
    } else {
        $hata = "Kullanıcı bulunamadı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Zenith EH - Sisteme Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Zenith Test Yönetimi</h4>
                        <?php if(isset($hata)) echo "<div class='alert alert-danger'>$hata</div>"; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Kullanıcı Adı</label>
                                <input type="text" name="kullanici_adi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Şifre</label>
                                <input type="password" name="sifre" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>