<?php include 'includes/header.php'; ?>
<?php include '../config/db.php'; ?>

<div class="container">
    <!-- Tombol untuk membuka modal tambah paket wisata -->
    <h3 class="my-4 text-center">Daftar Paket Wisata</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Tambah Paket
    </button>

    <!-- Tabel untuk menampilkan dan mengelola paket wisata -->
    <table class="table table-striped my-4">
        <thead>
            <tr class="bg-primary text-white">
                <th scope="col">#</th>
                <th scope="col">Nama Paket</th>
                <th scope="col">Biaya Penginapan</th>
                <th scope="col">Biaya Transportasi</th>
                <th scope="col">Biaya Makanan</th>
                <th scope="col">Gambar</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data dari tabel paket_wisata
            $sql = "SELECT * FROM paket_wisata";
            $stmt = $pdo->query($sql);
            $i = 1;
            while ($row = $stmt->fetch()) {
                echo    "<tr>
                            <td>{$i}</td>
                            <td>{$row['nama_paket']}</td>
                            <td>{$row['biaya_penginapan']}</td>
                            <td>{$row['biaya_transportasi']}</td>
                            <td>{$row['biaya_makanan']}</td>
                            <td><img src='{$row['gambar']}' alt='Gambar Paket' width='100'></td>
                            <td>{$row['deskripsi']}</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm editBtn' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['paket_wisata_id']}' data-nama='{$row['nama_paket']}' data-biaya-penginapan='{$row['biaya_penginapan']}' data-biaya-transportasi='{$row['biaya_transportasi']}' data-biaya-makanan='{$row['biaya_makanan']}' data-gambar='{$row['gambar']}' data-deskripsi='{$row['deskripsi']}'>Edit</button>
                                <button class='btn btn-danger btn-sm deleteBtn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='{$row['paket_wisata_id']}'>Hapus</button>
                            </td>
                        </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Paket -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="crud.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Paket Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
                    </div>
                    <div class="mb-3">
                        <label for="biaya_penginapan" class="form-label">Biaya Penginapan</label>
                        <input type="number" class="form-control" id="biaya_penginapan" name="biaya_penginapan" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="biaya_transportasi" class="form-label">Biaya Transportasi</label>
                        <input type="number" class="form-control" id="biaya_transportasi" name="biaya_transportasi" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="biaya_makanan" class="form-label">Biaya Makanan</label>
                        <input type="number" class="form-control" id="biaya_makanan" name="biaya_makanan" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="tambah_paket">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Paket -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="crud.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Paket Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nama_paket" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="edit_nama_paket" name="nama_paket" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_biaya_penginapan" class="form-label">Biaya Penginapan</label>
                        <input type="number" class="form-control" id="edit_biaya_penginapan" name="biaya_penginapan" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_biaya_transportasi" class="form-label">Biaya Transportasi</label>
                        <input type="number" class="form-control" id="edit_biaya_transportasi" name="biaya_transportasi" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_biaya_makanan" class="form-label">Biaya Makanan</label>
                        <input type="number" class="form-control" id="edit_biaya_makanan" name="biaya_makanan" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Gambar (Upload Baru)</label>
                        <input type="file" class="form-control" id="edit_gambar" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" name="edit_paket">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Paket -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="crud.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Paket Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="id">
                    <p>Apakah kamu yakin ingin menghapus paket ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" name="hapus_paket">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Untuk mengisi data pada modal edit
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit_id').value = button.getAttribute('data-id');
            document.getElementById('edit_nama_paket').value = button.getAttribute('data-nama');
            document.getElementById('edit_biaya_penginapan').value = button.getAttribute('data-biaya-penginapan');
            document.getElementById('edit_biaya_transportasi').value = button.getAttribute('data-biaya-transportasi');
            document.getElementById('edit_biaya_makanan').value = button.getAttribute('data-biaya-makanan');
            document.getElementById('edit_gambar').value = button.getAttribute('data-gambar');
            document.getElementById('edit_deskripsi').value = button.getAttribute('data-deskripsi');
        });
    });

    // Untuk mengisi ID pada modal hapus
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('delete_id').value = button.getAttribute('data-id');
        });
    });
</script>
<script>
    // Untuk mengisi data pada modal edit
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('edit_id').value = button.getAttribute('data-id');
        document.getElementById('edit_nama_paket').value = button.getAttribute('data-nama');
        document.getElementById('edit_biaya_penginapan').value = button.getAttribute('data-biaya-penginapan');
        document.getElementById('edit_biaya_transportasi').value = button.getAttribute('data-biaya-transportasi');
        document.getElementById('edit_biaya_makanan').value = button.getAttribute('data-biaya-makanan');
        document.getElementById('edit_gambar').value = ''; // Set gambar input field to empty
        document.getElementById('edit_deskripsi').value = button.getAttribute('data-deskripsi');
    });
});

// Untuk mengisi ID pada modal hapus
document.querySelectorAll('.deleteBtn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('delete_id').value = button.getAttribute('data-id');
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
