<?php 
include 'config/db.php';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Form Pemesanan Paket Wisata</h2>

    <!-- Tabel Pemesanan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pemesan</th>
                <th>No Telp</th>
                <th>Waktu Pelaksanaan</th>
                <th>Jumlah Peserta</th>
                <th>Paket Wisata</th>
                <th>Pelayanan</th>
                <th>Harga Paket</th>
                <th>Jumlah Tagihan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="data-pemesanan">
            <!-- Data pemesanan akan ditampilkan di sini -->
        </tbody>
    </table>

    <!-- Button Tambah Pemesanan -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#pemesananModal">Tambah Pemesanan</button>
</div>

<!-- Modal Tambah/Edit Pemesanan -->
<div class="modal fade" id="pemesananModal" tabindex="-1" role="dialog" aria-labelledby="pemesananModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pemesananModalLabel">Tambah Pemesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-pemesanan">
                    <input type="hidden" id="pemesanan_id">
                    <div class="form-group">
                        <label for="nama_pemesan">Nama Pemesan</label>
                        <input type="text" class="form-control" id="nama_pemesan" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telp</label>
                        <input type="text" class="form-control" id="no_telp" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_peserta">Jumlah Peserta</label>
                        <input type="number" id="jumlah_peserta" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="waktu_pelaksanaan_perjalanan">Lama Hari</label>
                        <input type="number" id="waktu_pelaksanaan_perjalanan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="paket_wisata_id">Paket Wisata</label>
                        <select id="paket_wisata_id" class="form-control" required>
                            <!-- Paket Wisata akan dimuat dari server -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pelayanan Paket Perjalanan</label><br>
                        <input type="checkbox" name="penginapan" value="1" id="penginapan"> Penginapan <br>
                        <input type="checkbox" name="transportasi" value="1" id="transportasi"> Transportasi <br>
                        <input type="checkbox" name="makanan" value="1" id="makanan"> Makanan <br>
                    </div>
                    <div class="form-group">
                        <label for="harga_paket">Harga Paket</label>
                        <input type="number" class="form-control" id="harga_paket" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tagihan">Jumlah Tagihan</label>
                        <input type="number" class="form-control" id="jumlah_tagihan" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS, jQuery, and AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    loadPaketWisata();
    loadDataPemesanan();

    // Event Submit Form Pemesanan
    $('#form-pemesanan').on('submit', function(e) {
        e.preventDefault();

        let data = {
            action: $('#pemesanan_id').val() ? 'update' : 'create',
            pemesanan_id: $('#pemesanan_id').val(),
            nama_pemesan: $('#nama_pemesan').val(),
            no_telp: $('#no_telp').val(),
            waktu_pelaksanaan_perjalanan: $('#waktu_pelaksanaan_perjalanan').val(),
            jumlah_peserta: $('#jumlah_peserta').val(),
            paket_wisata_id: $('#paket_wisata_id').val(),
            penginapan: $('#penginapan').is(':checked') ? 1 : 0,
            transportasi: $('#transportasi').is(':checked') ? 1 : 0,
            makanan: $('#makanan').is(':checked') ? 1 : 0
        };

        $.post('functionPemesanan.php', data, function(response) {
            $('#pemesananModal').modal('hide');
            loadDataPemesanan();
        }, 'json');
    });

    // Load Paket Wisata
    function loadPaketWisata() {
        $.get('functionPemesanan.php?action=getPaketWisata', function(response) {
            $('#paket_wisata_id').empty();
            response.forEach(paket => {
                $('#paket_wisata_id').append(`<option value="${paket.paket_wisata_id}">${paket.nama_paket}</option>`);
            });
        }, 'json');
    }

    // Load Data Pemesanan
    function loadDataPemesanan() {
        $.get('functionPemesanan.php?action=read', function(response) {
            $('#data-pemesanan').empty();
            response.forEach(data => {
                $('#data-pemesanan').append(`
                    <tr>
                        <td>${data.nama_pemesan}</td>
                        <td>${data.no_telp}</td>
                        <td>${data.waktu_pelaksanaan_perjalanan}</td>
                        <td>${data.jumlah_peserta}</td>
                        <td>${data.nama_paket}</td>
                        <td>${data.pelayanan}</td>
                        <td>${data.harga_paket}</td>
                        <td>${data.jumlah_tagihan}</td>
                        <td>
                            <button class="btn btn-warning btn-edit" data-id="${data.pemesanan_id}">Edit</button>
                            <button class="btn btn-danger btn-delete" data-id="${data.pemesanan_id}">Delete</button>
                        </td>
                    </tr>
                `);
            });
        }, 'json');
    }
});
</script>
<script>
    $(document).ready(function() {
    // Panggil fungsi saat halaman dimuat untuk memuat paket wisata
    loadPaketWisata();

    // Tambahkan event listener pada perubahan di select paket wisata atau checkbox
    $('#paket_wisata_id, #penginapan, #transportasi, #makanan').change(function() {
        calculateHargaPaket();  // Panggil fungsi untuk menghitung ulang harga
    });
});

function loadPaketWisata() {
    $.get('functionPemesanan.php?action=getPaketWisata', function(response) {
        $('#paket_wisata_id').empty();
        response.forEach(paket => {
            $('#paket_wisata_id').append(`<option value="${paket.paket_wisata_id}">${paket.nama_paket}</option>`);
        });
    }, 'json');
}

function calculateHargaPaket() {
    const paketWisataId = $('#paket_wisata_id').val();
    const penginapan = $('#penginapan').is(':checked') ? 1 : 0;
    const transportasi = $('#transportasi').is(':checked') ? 1 : 0;
    const makanan = $('#makanan').is(':checked') ? 1 : 0;
    const jumlahPeserta = $('#jumlah_peserta').val();
    const lamaHari = $('#waktu_pelaksanaan_perjalanan').val();

    if (paketWisataId) {
        // Kirim request ke server untuk menghitung harga berdasarkan pilihan
        $.post('functionPemesanan.php', {
            action: 'calculate',
            paket_wisata_id: paketWisataId,
            penginapan: penginapan,
            transportasi: transportasi,
            makanan: makanan
        }, function(response) {
            // Response berisi harga_paket dan jumlah_tagihan
            $('#harga_paket').val(response.harga_paket);

            // Hitung jumlah tagihan jika jumlah peserta dan lama hari ada
            if (jumlahPeserta && lamaHari) {
                const jumlahTagihan = response.harga_paket * jumlahPeserta * lamaHari;
                $('#jumlah_tagihan').val(jumlahTagihan);
            }
        }, 'json');
    }
}

</script>
</body>
</html>

