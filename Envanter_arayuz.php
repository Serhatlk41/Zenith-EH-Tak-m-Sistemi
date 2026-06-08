<?php
session_start();
if (!isset($_SESSION['uye_id'])) { header("Location: login.php"); exit; }

require_once 'Envanter.php';
$envanterSinifi = new Envanter();

// Yeni modül ekleme formu gönderildiyse (Create İşlemi)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modul_ekle'])) {
    $envanterSinifi->modulEkle($_POST['modul_adi'], $_POST['kategori'], $_POST['stok_durumu']);
    header("Location: envanter.php"); // Sayfayı yenile
    exit;
}

// Tüm envanteri çek (Read İşlemi)
$moduller = $envanterSinifi->tumEnvanteriGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Zenith EH - Envanter Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">ZENITH EH TAKIMI</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="index.php">Saha Testleri</a>
                <a class="nav-link active" href="envanter.php">Envanter & Modüller</a>
            </div>
            <div class="d-flex text-light align-items-center">
                <span class="me-3">Hoş geldin, <strong><?php echo $_SESSION['ad_soyad']; ?></strong></span>
                <a href="logout.php" class="btn btn-sm btn-danger">Çıkış Yap</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">Yeni Donanım Ekle</div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="modul_ekle" value="1">
                            <div class="mb-3">
                                <label class="form-label">Modül/Devre Adı</label>
                                <input type="text" name="modul_adi" class="form-control" placeholder="Örn: 4-Terimli Kod Çevirici" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="SDR">SDR Cihazı</option>
                                    <option value="RF Donanım">RF Donanım</option>
                                    <option value="Anten">Anten</option>
                                    <option value="Lojik Devre">Lojik Devre</option>
                                    <option value="Simülasyon Dosyası">Simülasyon Dosyası</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Başlangıç Durumu</label>
                                <select name="stok_durumu" class="form-select" required>
                                    <option value="Kullanıma Hazır">Kullanıma Hazır</option>
                                    <option value="Testte">Testte</option>
                                    <option value="Arızalı">Arızalı</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Envantere Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">Mevcut Envanter Listesi</div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover m-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>ID</th>
                                    <th>Modül Adı</th>
                                    <th>Kategori</th>
                                    <th>Durum</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $moduller->fetch(PDO::FETCH_OBJ)): ?>
                                <tr>
                                    <td><?php echo $row->id; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row->modul_adi); ?></strong>
                                    </td>
                                    <td><?php echo $row->kategori; ?></td>
                                    <td>
                                        <?php 
                                            $renk = "bg-success";
                                            if($row->stok_durumu == 'Testte') $renk = "bg-warning text-dark";
                                            if($row->stok_durumu == 'Arızalı') $renk = "bg-danger";
                                        ?>
                                        <span class="badge <?php echo $renk; ?>"><?php echo $row->stok_durumu; ?></span>
                                    </td>
                                    <td>
                                        <a href="envanter_sil.php?id=<?php echo $row->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Envanterden silmek istediğinize emin misiniz?');">Sil</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>