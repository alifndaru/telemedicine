<div class="provider-container">
    <div class="provider-sidebar">
        <h3>DATA PROVIDER KAMI</h3>
        <ul>
            <?php foreach ($perangkat_daerah as $data): ?>
                <?php if (!empty($data['perangkat_daerah'])):
                ?>
                    <li>
                        <a href="<?= base_url('list-layanan?kualifikasi=' . urlencode($data['perangkat_daerah'])); ?>">
                            <?= $data['perangkat_daerah']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            <li>
                <a href="<?= base_url('list-layanan'); ?>">Semua Spesialis</a>
            </li>
        </ul>
    </div>
    <div class="provider-content">
        <?php if (!empty($doctors)): ?>
            <?php foreach ($doctors as $row): ?>
                <div class="provider-item">
                    <img src="<?= base_url('asset/foto_user/' . trim($row['foto'])); ?>" alt="">
                    <div class="provider-info">
                        <h4><?= $row['nama_lengkap'] ?></h4>
                        <p class="specialization">Kualifikasi: <?= $row['perangkat_daerah'] ?></p>
                        <p class="location">Spesialis: <?= $row['spesialis'] ?></p>
                        <p class="address">Klinik: <?= $row['klinik'] ?></p>
                    </div>
                    <div class="provider-buttons">
                        <button class="profile-btn">PROFIL</button>
                        <button class="consult-btn">KONSULTASI</button>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="pagination">
                <?= $this->pagination->create_links(); ?>
            </div>
        <?php else: ?>
            <p>Data dokter tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</div>