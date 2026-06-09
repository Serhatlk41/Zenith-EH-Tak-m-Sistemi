# 🚀 Zenith Elektronik Harp (EH) Takımı - Sistem Yönetim Paneli

Bu proje, Bursa Teknik Üniversitesi **Zenith Elektronik Harp Takımı**'nın Teknofest hazırlık sürecinde saha testlerini, envanter durumunu ve donanım modüllerini kayıt altına almak amacıyla sıfırdan geliştirilmiş web tabanlı bir yönetim sistemidir. 

Sistem, hiçbir harici kütüphane veya framework kullanılmadan, tamamen Yalın PHP ve Nesne Yönelimli Programlama standartlarına bağlı kalınarak inşa edilmiştir.

## 🎯 Projenin Amacı ve Çözdüğü Sorunlar
Teknofest gibi yüksek mühendislik ve takım çalışması gerektiren yarışmalarda, saha testlerinden elde edilen verilerin ve laboratuvardaki donanım (SDR, RF, Anten vb.) durumlarının anlık olarak takip edilmesi kritik bir öneme sahiptir. Bu sistem; Serhat, Hamza, Berra, Sude ve Anıl'dan oluşan Zenith takımının sahadaki koordinasyonunu dijitalleştirmeyi ve test süreçlerini kayıt altına almayı amaçlamaktadır.

## ⚙️ Teknik Altyapı ve Kurallar
Bu sistem, Web Programlama dersi kısıtlamalarına ve modern güvenlik standartlarına harfi harfine uyacak şekilde tasarlanmıştır:
* **Arka Uç (Backend):** Yalın PHP 8.x
* **Veritabanı Yönetimi:** MySQL (PDO - PHP Data Objects kullanılarak)
* **Arayüz Tasarımı:** Bootstrap 5 (CDN üzerinden)
* **Oturum Yönetimi:** Güvenli `$_SESSION` yapıları
* **Şifreleme:** `password_hash()` ile veritabanında şifre güvenliği
* **Mimari:** OOP standartlarında `Database`, `SahaTestleri` ve `Envanter` sınıfları.

## 📸 Ekran Görüntüleri ve Tanıtım

* **Saha Testleri Panosu:**
<img width="1918" height="927" alt="sahatestleriss" src="https://github.com/user-attachments/assets/9efc9e40-1085-4eaa-8ce0-c974c409e1b6" />

* **Envanter Yönetimi:**
<img width="1907" height="927" alt="envanterss" src="https://github.com/user-attachments/assets/754fcb12-0ef4-4d58-93b0-01af7a9b4a7c" />


🎥 **Proje Tanıtım Videosu:** 
https://youtu.be/6UFUJ2GspgY?si=5577ofjJ5FN3gbs8

## 💻 Kurulum ve Test (Değerlendiriciler İçin)
Sistemi lokal ortamınızda test etmek isterseniz:
1.  Bu repoyu bilgisayarınıza indirin (`htdocs` veya `www` dizinine).
2.  Klasör içerisindeki `zenith_eh_systems.sql` dosyasını phpMyAdmin üzerinden veritabanınıza içe aktarın (Import).
3.  `config.php` dosyasındaki veritabanı bilgilerinizi kendi sunucunuza göre güncelleyin.
4.  Tarayıcınızdan dizine giderek sisteme giriş yapın.

> **⚠️ Test Hesabı Bilgileri:**
> * **Kullanıcı Adı:** `hoca` 
> * **Şifre:** `123456`

---
*Bu sistem, Serhat Tilki tarafından geliştirilmiştir.*
