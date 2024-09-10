<?php
$host = 'localhost'; // Sesuaikan dengan konfigurasi host kamu
$db = 'kampungdurian'; // Ganti dengan nama database
$user = 'root'; // User database kamu
$pass = ''; // Password user database kamu

// Data Source Name (DSN) untuk koneksi ke MySQL
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// Opsi PDO untuk koneksi database
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Menampilkan pesan error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mengambil data sebagai array asosiatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Menonaktifkan emulasi prepared statements
];

try {
    // Mencoba membuat koneksi dengan PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Menangani error koneksi dan menampilkan pesan error
    echo "Koneksi gagal: " . $e->getMessage();
    exit(); // Menghentikan eksekusi script jika koneksi gagal
}
?>
