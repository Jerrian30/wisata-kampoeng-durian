
<?php
include 'config/db.php'; // Include file koneksi database

// Ambil data paket wisata dari database
$sql = "SELECT * FROM paket_wisata";
$stmt = $pdo->query($sql);
$paket_wisata = $stmt->fetchAll();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kampoeng Durian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <div class="position-relative">
            <img src="assets/img/header.png" class="d-block w-100" alt="Gambar Header Kampoeng Durian">
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand text-dark fw-bold" href="#">KAMPOENG DURIAN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/about.php">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="form_pemesanan.php">Pemesanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth/login.php">Log in</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>