<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil data dari request
$paket_id = $_GET['paket_id'];
$user_id = $_SESSION['user_id'];

// Simpan pesanan ke database
$query = "INSERT INTO orders (user_id, paket_id, status) VALUES (?, ?, 'Menunggu Konfirmasi')";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id, $paket_id]);

header("Location: ../member/my_orders.php");
?>
