<div class="lokasi-container">
    <h2>LOKASI PKBI</h2>
    <div class="lokasi-content">
        <?php foreach ($klinik as $data) { ?>
            <div class="lokasi-item">
                <img src="path/to/klinik1.jpg" alt="Klinik PROCARE">
                <div class="lokasi-info">
                    <h4><?= $data['klinik']; ?></h4>
                    <p><?= $data['alamat'] ?></p>
                    <p>Nomor Telepon: <?= $data['phone'] ?></p>
                    <!-- <a href="#" class="profil-btn">Profil & Layanan</a> -->
                </div>
            </div>
        <?php } ?>
        <!-- Tambahkan item lokasi lainnya sesuai kebutuhan -->
    </div>
    <div class="pagination">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">next</a>
    </div>
</div>