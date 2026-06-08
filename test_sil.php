<?php
session_start();
if (!isset($_SESSION['uye_id'])) { header("Location: login.php"); exit; }

require_once 'SahaTestleri.php';

if (isset($_GET['id'])) {
    $testSinifi = new SahaTestleri();
    $testSinifi->testSil($_GET['id']);
}

// İşlem bitince ana sayfaya yönlendir
header("Location: index.php");
exit;
?>