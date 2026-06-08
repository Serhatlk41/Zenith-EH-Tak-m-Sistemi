<?php
session_start();

if (!isset($_SESSION['uye_id'])) { 
    header("Location: login.php"); 
    exit; 
}

if (isset($_GET['id'])) {
    require_once 'Envanter.php';
    $envanterSinifi = new Envanter();
    
    $silinecek_id = $_GET['id'];
    $envanterSinifi->modulSil($silinecek_id);
}

header("Location: envanter_arayuz.php");
exit;
?>