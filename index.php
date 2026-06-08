<?php
session_start();
// Oturum kontrolü: Giriş yapılmamışsa login'e at
if (!isset($_SESSION['uye_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'SahaTestleri.php';
$testSinifi = new SahaTestleri();
$testler = $testSinifi->tumTestleriGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Zenith EH - Saha Testleri Panosu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ZENITH EH TAKIMI</a>
            <div class="d-flex text-light align-items-center">
                <span class="me-3">Hoş geldin, <strong><?php echo $_SESSION['ad_soyad']; ?></strong> (<?php echo $_SESSION['uzmanlik']; ?>)</span>
                <a href="logout.php" class="btn btn-sm btn-danger">Çıkış Yap</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Görev ve Test Kayıtları</h2>
            <a href="test_ekle.php" class="btn btn-success">+ Yeni Test Ekle (Create)</a>
        </div>

        <div class="table-responsive shadow">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Test Adı</th>
                        <th>Ana Görev</th>
                        <th>Alt Görev</th>
                        <th>Hedef Sinyal</th>
                        <th>Sonuç</th>
                        <th>Raportör</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $testler->fetch(PDO::FETCH_OBJ)): ?>
                    <tr>
                        <td><?php echo $row->id; ?></td>
                        <td><?php echo htmlspecialchars($row->test_adi); ?></td>
                        <td><?php echo $row->ana_gorev; ?></td>
                        <td><?php echo $row->alt_gorev; ?></td>
                        <td><?php echo $row->hedef_sinyal_tipi; ?></td>
                        <td>
                            <?php 
                                $badge = "bg-warning";
                                if($row->genel_sonuc == 'Başarılı') $badge = "bg-success";
                                if($row->genel_sonuc == 'Başarısız') $badge = "bg-danger";
                            ?>
                            <span class="badge <?php echo $badge; ?>"><?php echo $row->genel_sonuc; ?></span>
                        </td>
                        <td><?php echo $row->raportor_adi; ?></td>
                        <td>
                            <a href="test_duzenle.php?id=<?php echo $row->id; ?>" class="btn btn-sm btn-primary">Düzenle</a>
                            <a href="test_sil.php?id=<?php echo $row->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>