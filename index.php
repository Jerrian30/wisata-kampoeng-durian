<?php
include 'includes/header.php';

?>


    <section class="container-fluid my-4">
        <div class="row">
            <div class="col-md-4 order-md-2">
                <div class="sidebar">
                    <input type="text" class="form-control mb-3" placeholder="Cari...">
                    <div class="video-container mb-4">
                        <iframe src="https://www.youtube.com/embed/8VdhlBtlKEU?si=Jz826zH_J9I8bc3i" title="Video Promosi Kampoeng Durian" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <div class="col-md-8 order-md-1">
                <div id="paketPenginapan">
                    <div class="row">
                        <?php foreach ($paket_wisata as $paket): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <img src="<?= htmlspecialchars($paket['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($paket['nama_paket']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($paket['nama_paket']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($paket['deskripsi']) ?></p>
                                    <p class="card-text"><small class="text-muted"><i class="bi bi-clock-fill"></i> <?= date('d M Y', strtotime($paket['created_at'])) ?></small></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-light text-center py-3">
        <p>&copy; 2024 Kampoeng Durian. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
