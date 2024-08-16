<div class="provider-container">
	<div class="provider-sidebar">
		<h3>DATA PROVIDER KAMI</h3>
		<ul>
			<?php foreach ($jabatan as $data): ?>
				<li>
					<a href="<?= base_url('psikolog/lists?spesialis=' . urlencode($data['spesialis'])); ?>">
						<?= htmlspecialchars($data['spesialis'], ENT_QUOTES, 'UTF-8'); ?>
					</a>
				</li>
			<?php endforeach; ?>
			<!-- Tambahkan item untuk 'Semua Spesialis' -->
			<li>
				<a href="<?= base_url('psikolog/lists'); ?>">Semua Spesialis</a>
			</li>
		</ul>
	</div>
	<div class="provider-content">
		<?php foreach ($doctors as $row): ?>
			<div class="provider-item">
				<img src="<?= base_url('asset/foto_user/' . trim($row['foto'])); ?>" alt="">
				<div class="provider-info">
					<h4><?= $row['nama_lengkap'] ?></h4>
					<p class="specialization">Jabatan: <?= $row['perangkat_daerah'] ?></p>
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
	</div>
</div>