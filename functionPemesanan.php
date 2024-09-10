<?php
include 'config/db.php';

// Ambil data paket wisata
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'getPaketWisata') {
    $stmt = $pdo->query("SELECT paket_wisata_id, nama_paket FROM paket_wisata");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Ambil data pemesanan
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'read') {
    $stmt = $pdo->query("
        SELECT f.*, p.nama_paket 
        FROM form_pemesanan f 
        JOIN paket_wisata p ON f.paket_wisata_id = p.paket_wisata_id
    ");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Create/Update pemesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pemesan = $_POST['nama_pemesan'];
    $no_telp = $_POST['no_telp'];
    $waktu_pelaksanaan_perjalanan = $_POST['waktu_pelaksanaan_perjalanan'];
    $jumlah_peserta = $_POST['jumlah_peserta'];
    $paket_wisata_id = $_POST['paket_wisata_id'];
    $penginapan = $_POST['penginapan'];
    $transportasi = $_POST['transportasi'];
    $makanan = $_POST['makanan'];

    $stmt = $pdo->prepare("SELECT biaya_penginapan, biaya_transportasi, biaya_makanan FROM paket_wisata WHERE paket_wisata_id = ?");
    $stmt->execute([$paket_wisata_id]);
    $biaya = $stmt->fetch(PDO::FETCH_ASSOC);

    $harga_paket = 0;
    if ($penginapan) $harga_paket += $biaya['biaya_penginapan'];
    if ($transportasi) $harga_paket += $biaya['biaya_transportasi'];
    if ($makanan) $harga_paket += $biaya['biaya_makanan'];

    $jumlah_tagihan = $harga_paket * $jumlah_peserta * $waktu_pelaksanaan_perjalanan;

    if ($_POST['action'] == 'create') {
        $stmt = $pdo->prepare("
            INSERT INTO form_pemesanan (nama_pemesan, no_telp, waktu_pelaksanaan_perjalanan, jumlah_peserta, paket_wisata_id, harga_paket, jumlah_tagihan, penginapan, transportasi, makanan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$nama_pemesan, $no_telp, $waktu_pelaksanaan_perjalanan, $jumlah_peserta, $paket_wisata_id, $harga_paket, $jumlah_tagihan, $penginapan, $transportasi, $makanan]);
    } else if ($_POST['action'] == 'update') {
        $pemesanan_id = $_POST['pemesanan_id'];
        $stmt = $pdo->prepare("
            UPDATE form_pemesanan SET 
            nama_pemesan = ?, no_telp = ?, waktu_pelaksanaan_perjalanan = ?, jumlah_peserta = ?, paket_wisata_id = ?, harga_paket = ?, jumlah_tagihan = ?, penginapan = ?, transportasi = ?, makanan = ?
            WHERE pemesanan_id = ?
        ");
        $stmt->execute([$nama_pemesan, $no_telp, $waktu_pelaksanaan_perjalanan, $jumlah_peserta, $paket_wisata_id, $harga_paket, $jumlah_tagihan, $penginapan, $transportasi, $makanan, $pemesanan_id]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'calculate') {
    $paket_wisata_id = $_POST['paket_wisata_id'];
    $penginapan = $_POST['penginapan'];
    $transportasi = $_POST['transportasi'];
    $makanan = $_POST['makanan'];

    // Ambil biaya dari paket_wisata berdasarkan paket_wisata_id
    $stmt = $pdo->prepare("SELECT biaya_penginapan, biaya_transportasi, biaya_makanan FROM paket_wisata WHERE paket_wisata_id = ?");
    $stmt->execute([$paket_wisata_id]);
    $paket = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kalkulasi harga_paket
    $harga_paket = 0;
    if ($penginapan) {
        $harga_paket += $paket['biaya_penginapan'];
    }
    if ($transportasi) {
        $harga_paket += $paket['biaya_transportasi'];
    }
    if ($makanan) {
        $harga_paket += $paket['biaya_makanan'];
    }

    echo json_encode(['harga_paket' => $harga_paket]);
}

?>
