<?php
session_start();
require '../config/db.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Ambil data dari form
$paket_name = $_POST['paket_name'];
$paket_description = $_POST['paket_description'];

// Simpan paket wisata ke database
$query = "INSERT INTO paket_wisata (name, description) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$paket_name, $paket_description]);

header("Location: ../admin/manage_paket.php");
?>
