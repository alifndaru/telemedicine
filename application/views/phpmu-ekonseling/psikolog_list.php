<div class="provider-container">
	<div class="provider-sidebar">
		<h3>DATA PROVIDER KAMI</h3>
		<ul>
			<!-- <li><a href="#">Dokter Spesialis</a></li> -->
			<!-- <?php foreach ($layanan_ipes as $layanan): ?>
				<li><?= htmlspecialchars($layanan['nama_kategori_layanan'], ENT_QUOTES, 'UTF-8'); ?></li>
			<?php endforeach; ?> -->

			<?php foreach ($layanan_ipes as $layanan): ?>
				<li>
					<a href="#">
						<?= htmlspecialchars($layanan['nama_kategori_layanan'], ENT_QUOTES, 'UTF-8'); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="provider-content">
		<?php foreach ($psikolog->result_array() as $row) {
		?>
			<div class="provider-item">
				<img src="<?php echo base_url('asset/foto_user/' . trim($row['foto_dokter'])); ?>" alt="">
				<div class="provider-info">
					<h4><?= $row['nama_lengkap'] ?></h4>
					<p class="specialization"><?= $row['jabatan'] ?></p>
					<p class="location"><?= $row['klinik'] ?></p>
					<p class="address"><?= $row['alamat_klinik'] ?>, <?= $row['provinsi'] ?></p>
				</div>
				<div class="provider-buttons">
					<button class="profile-btn">PROFIL</button>
					<button class="consult-btn">KONSULTASI</button>
				</div>
			</div>
		<?php } ?>
		<!-- Tambahkan item provider lainnya sesuai kebutuhan -->
		<div class="pagination">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>