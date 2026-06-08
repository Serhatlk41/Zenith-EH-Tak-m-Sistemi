-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Haz 2026, 14:15:25
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `zenith_eh_systems`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `envanter_ve_moduller`
--

CREATE TABLE `envanter_ve_moduller` (
  `id` int(11) NOT NULL,
  `modul_adi` varchar(150) NOT NULL,
  `kategori` enum('RF Donanım','Lojik Devre','Anten','SDR','Simülasyon Dosyası') NOT NULL,
  `stok_durumu` enum('Kullanıma Hazır','Testte','Arızalı') DEFAULT 'Kullanıma Hazır',
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `saha_testleri`
--

CREATE TABLE `saha_testleri` (
  `id` int(11) NOT NULL,
  `test_adi` varchar(150) NOT NULL,
  `ana_gorev` enum('Elektronik Destek','Elektronik Taarruz') NOT NULL,
  `alt_gorev` varchar(100) NOT NULL,
  `hedef_sinyal_tipi` varchar(100) NOT NULL,
  `baslangic_tarihi` datetime NOT NULL,
  `bitis_tarihi` datetime DEFAULT NULL,
  `genel_sonuc` enum('Başarılı','Kısmi Başarılı','Başarısız') DEFAULT 'Başarısız',
  `raportor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `saha_testleri`
--

INSERT INTO `saha_testleri` (`id`, `test_adi`, `ana_gorev`, `alt_gorev`, `hedef_sinyal_tipi`, `baslangic_tarihi`, `bitis_tarihi`, `genel_sonuc`, `raportor_id`) VALUES
(4, 'X Bant Karıştırma Testi', 'Elektronik Taarruz', 'Sinyal Tespiti', 'Amatör Telsiz', '2026-06-02 14:54:00', NULL, 'Başarısız', 1),
(5, 'X Bant Karıştırma Testi', 'Elektronik Taarruz', 'Sinyal Tespiti', 'Amatör Telsiz', '2026-06-02 15:03:00', NULL, 'Başarılı', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takim_uyeleri`
--

CREATE TABLE `takim_uyeleri` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `uzmanlik_alani` enum('Sistem','Donanım','Yazılım','Mekanik') NOT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `takim_uyeleri`
--

INSERT INTO `takim_uyeleri` (`id`, `kullanici_adi`, `sifre`, `ad_soyad`, `uzmanlik_alani`, `kayit_tarihi`) VALUES
(1, 'SerhaIT', '$2y$10$bzskevokkOOLhOX2bO1suuUhft/X3BkFA1RYKX5ZTBbZR.o3Zbipq', 'Sistem Yöneticisi', 'Sistem', '2026-06-02 11:23:09'),
(3, 'hoca', '$2y$10$pGi52d1iVOg1zKHjVc8g3Op1txGLNNyRTl46HKwOq7j9SufV5aEQ6', 'Hoca', '', '2026-06-08 12:06:33');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `test_ekibi`
--

CREATE TABLE `test_ekibi` (
  `test_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `gorevi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `test_parametreleri`
--

CREATE TABLE `test_parametreleri` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `kullanilan_modul_id` int(11) DEFAULT NULL,
  `parametre_adi` varchar(100) NOT NULL,
  `parametre_degeri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `envanter_ve_moduller`
--
ALTER TABLE `envanter_ve_moduller`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `saha_testleri`
--
ALTER TABLE `saha_testleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raportor_id` (`raportor_id`);

--
-- Tablo için indeksler `takim_uyeleri`
--
ALTER TABLE `takim_uyeleri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`);

--
-- Tablo için indeksler `test_ekibi`
--
ALTER TABLE `test_ekibi`
  ADD PRIMARY KEY (`test_id`,`uye_id`),
  ADD KEY `uye_id` (`uye_id`);

--
-- Tablo için indeksler `test_parametreleri`
--
ALTER TABLE `test_parametreleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `kullanilan_modul_id` (`kullanilan_modul_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `envanter_ve_moduller`
--
ALTER TABLE `envanter_ve_moduller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `saha_testleri`
--
ALTER TABLE `saha_testleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `takim_uyeleri`
--
ALTER TABLE `takim_uyeleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `test_parametreleri`
--
ALTER TABLE `test_parametreleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `saha_testleri`
--
ALTER TABLE `saha_testleri`
  ADD CONSTRAINT `saha_testleri_ibfk_1` FOREIGN KEY (`raportor_id`) REFERENCES `takim_uyeleri` (`id`);

--
-- Tablo kısıtlamaları `test_ekibi`
--
ALTER TABLE `test_ekibi`
  ADD CONSTRAINT `test_ekibi_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `saha_testleri` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_ekibi_ibfk_2` FOREIGN KEY (`uye_id`) REFERENCES `takim_uyeleri` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `test_parametreleri`
--
ALTER TABLE `test_parametreleri`
  ADD CONSTRAINT `test_parametreleri_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `saha_testleri` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_parametreleri_ibfk_2` FOREIGN KEY (`kullanilan_modul_id`) REFERENCES `envanter_ve_moduller` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
