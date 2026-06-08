<?php
session_start();
if (!isset($_SESSION['uye_id'])) { header("Location: login.php"); exit; }

require_once 'SahaTestleri.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $testSinifi = new SahaTestleri();
    
    // Formdan gelen veriler
    $test_adi = $_POST['test_adi'];
    $ana_gorev = $_POST['ana_gorev'];
    $alt_gorev = $_POST['alt_gorev'];
    $hedef_sinyal = $_POST['hedef_sinyal_tipi'];
    $baslangic = $_POST['baslangic_tarihi'];
    $sonuc = $_POST['genel_sonuc'];
    $raportor_id = $_SESSION['uye_id']; // Testi ekleyen kişi, oturum açan kişidir

    if ($testSinifi->testEkle($test_adi, $ana_gorev, $alt_gorev, $hedef_sinyal, $baslangic, $sonuc, $raportor_id)) {
        header("Location: index.php");
        exit;
    } else {
        $hata = "Test eklenirken bir sorun oluştu.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Test Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Yeni Saha Testi Ekle</h4>
        </div>
        <div class="card-body">
            <?php if(isset($hata)) echo "<div class='alert alert-danger'>$hata</div>"; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Test Adı</label>
                    <input type="text" name="test_adi" class="form-control" required placeholder="Örn: X Bant Karıştırma Testi">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ana Görev</label>
                        <select name="ana_gorev" class="form-select" required>
                            <option value="Elektronik Destek">Elektronik Destek</option>
                            <option value="Elektronik Taarruz">Elektronik Taarruz</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alt Görev</label>
                        <input type="text" name="alt_gorev" class="form-control" required placeholder="Örn: Sinyal Tespiti">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Hedef Sinyal</label>
                        <input type="text" name="hedef_sinyal_tipi" class="form-control" required placeholder="Örn: Amatör Telsiz">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="datetime-local" name="baslangic_tarihi" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Genel Sonuç</label>
                        <select name="genel_sonuc" class="form-select" required>
                            <option value="Geliştirme Aşamasında">Geliştirme Aşamasında</option>
                            <option value="Başarılı">Başarılı</option>
                            <option value="Kısmi Başarılı">Kısmi Başarılı</option>
                            <option value="Başarısız">Başarısız</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Kaydet</button>
                <a href="index.php" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>