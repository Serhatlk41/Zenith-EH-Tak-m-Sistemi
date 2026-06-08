<?php
session_start();
if (!isset($_SESSION['uye_id'])) { header("Location: login.php"); exit; }

require_once 'SahaTestleri.php';
$testSinifi = new SahaTestleri();

if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$test_id = $_GET['id'];

// Mevcut test verisini çek
$mevcut_test = $testSinifi->testGetir($test_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test_adi = $_POST['test_adi'];
    $ana_gorev = $_POST['ana_gorev'];
    $alt_gorev = $_POST['alt_gorev'];
    $hedef_sinyal = $_POST['hedef_sinyal_tipi'];
    $sonuc = $_POST['genel_sonuc'];

    if ($testSinifi->testGuncelle($test_id, $test_adi, $ana_gorev, $alt_gorev, $hedef_sinyal, $sonuc)) {
        header("Location: index.php");
        exit;
    } else {
        $hata = "Test güncellenirken bir sorun oluştu.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Test Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Saha Testini Düzenle</h4>
        </div>
        <div class="card-body">
            <?php if(isset($hata)) echo "<div class='alert alert-danger'>$hata</div>"; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Test Adı</label>
                    <input type="text" name="test_adi" class="form-control" value="<?php echo htmlspecialchars($mevcut_test->test_adi); ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ana Görev</label>
                        <select name="ana_gorev" class="form-select" required>
                            <option value="Elektronik Destek" <?php echo ($mevcut_test->ana_gorev == 'Elektronik Destek') ? 'selected' : ''; ?>>Elektronik Destek</option>
                            <option value="Elektronik Taarruz" <?php echo ($mevcut_test->ana_gorev == 'Elektronik Taarruz') ? 'selected' : ''; ?>>Elektronik Taarruz</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alt Görev</label>
                        <input type="text" name="alt_gorev" class="form-control" value="<?php echo htmlspecialchars($mevcut_test->alt_gorev); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hedef Sinyal</label>
                        <input type="text" name="hedef_sinyal_tipi" class="form-control" value="<?php echo htmlspecialchars($mevcut_test->hedef_sinyal_tipi); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Genel Sonuç</label>
                        <select name="genel_sonuc" class="form-select" required>
                            <option value="Geliştirme Aşamasında" <?php echo ($mevcut_test->genel_sonuc == 'Geliştirme Aşamasında') ? 'selected' : ''; ?>>Geliştirme Aşamasında</option>
                            <option value="Başarılı" <?php echo ($mevcut_test->genel_sonuc == 'Başarılı') ? 'selected' : ''; ?>>Başarılı</option>
                            <option value="Kısmi Başarılı" <?php echo ($mevcut_test->genel_sonuc == 'Kısmi Başarılı') ? 'selected' : ''; ?>>Kısmi Başarılı</option>
                            <option value="Başarısız" <?php echo ($mevcut_test->genel_sonuc == 'Başarısız') ? 'selected' : ''; ?>>Başarısız</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="index.php" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>