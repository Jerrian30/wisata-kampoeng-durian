<?php
include '../config/db.php';

// Pastikan folder uploads ada
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Fungsi untuk mengupload gambar
function uploadFile($file) {
    $targetDir = "../assets/img/uploads/";
    $targetFile = $targetDir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Cek jika file gambar
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($file["size"] > 500000) {
        echo "Maaf, file terlalu besar.";
        $uploadOk = 0;
    }

    // Hanya izinkan format gambar tertentu
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Maaf, hanya format JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk bernilai 0 karena kesalahan
    if ($uploadOk == 0) {
        return false;
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
            return false;
        }
    }
}

// Tambah Paket Wisata
if (isset($_POST['tambah_paket'])) {
    $nama_paket = $_POST['nama_paket'];
    $biaya_penginapan = $_POST['biaya_penginapan'];
    $biaya_transportasi = $_POST['biaya_transportasi'];
    $biaya_makanan = $_POST['biaya_makanan'];
    $gambar = uploadFile($_FILES['gambar']);
    $deskripsi = $_POST['deskripsi'];

    if ($gambar) {
        $sql = "INSERT INTO paket_wisata (nama_paket, biaya_penginapan, biaya_transportasi, biaya_makanan, gambar, deskripsi) VALUES (:nama_paket, :biaya_penginapan, :biaya_transportasi, :biaya_makanan, :gambar, :deskripsi)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama_paket' => $nama_paket,
            ':biaya_penginapan' => $biaya_penginapan,
            ':biaya_transportasi' => $biaya_transportasi,
            ':biaya_makanan' => $biaya_makanan,
            ':gambar' => $gambar,
            ':deskripsi' => $deskripsi,
        ]);
        echo "Paket wisata berhasil ditambahkan.";
    } else {
        echo "Gambar gagal diupload.";
    }

    header('Location: paket_wisata.php');
    exit();
}

// Edit Paket Wisata
if (isset($_POST['edit_paket'])) {
    $id = $_POST['id'];
    $nama_paket = $_POST['nama_paket'];
    $biaya_penginapan = $_POST['biaya_penginapan'];
    $biaya_transportasi = $_POST['biaya_transportasi'];
    $biaya_makanan = $_POST['biaya_makanan'];
    $gambar = $_FILES['gambar']['name'] ? uploadFile($_FILES['gambar']) : $_POST['current_gambar']; // jika gambar tidak diupload, gunakan gambar lama
    $deskripsi = $_POST['deskripsi'];

    $sql = "UPDATE paket_wisata SET nama_paket = :nama_paket, biaya_penginapan = :biaya_penginapan, biaya_transportasi = :biaya_transportasi, biaya_makanan = :biaya_makanan, gambar = :gambar, deskripsi = :deskripsi WHERE paket_wisata_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':nama_paket' => $nama_paket,
        ':biaya_penginapan' => $biaya_penginapan,
        ':biaya_transportasi' => $biaya_transportasi,
        ':biaya_makanan' => $biaya_makanan,
        ':gambar' => $gambar,
        ':deskripsi' => $deskripsi,
    ]);

    echo "Paket wisata berhasil diperbarui.";
    header('Location: paket_wisata.php');
    exit();
}

// Hapus Paket Wisata
if (isset($_POST['hapus_paket'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM paket_wisata WHERE paket_wisata_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    echo "Paket wisata berhasil dihapus.";
    header('Location: paket_wisata.php');
    exit();
}
?>
