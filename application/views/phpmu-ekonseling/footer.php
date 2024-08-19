<footer class="footer">
	<div class="footer-top">
		<div class="footer-left">
			<div class="footer-logo">
				<?php
				$logo = $this->model_utama->view_ordering_limit('logo', 'id_logo', 'DESC', 0, 1);
				foreach ($logo->result_array() as $row) {
					echo "<a href='" . base_url() . "'><img class='logo' src='" . base_url() . "asset/logo/$row[gambar]'/></a>";
				}
				?>
			</div>
			<div class="social-icons">
				<a href="#"><img src="<?= base_url(); ?>asset/icon/icon/ig-1.png" alt="Instagram"></a>
				<a href="#"><img src="<?= base_url(); ?>asset/icon/icon/twitter-1.png" alt="Twitter"></a>
				<a href="#"><img src="<?= base_url(); ?>asset/icon/icon/yt.png" alt="YouTube"></a>
			</div>
		</div>

		<div class="footer-right">
			<p>Jl. Hang Jebat III/F Kebayoran Baru Jakarta Selatan</p>
			<p>Telepon: +62 8119727312</p>
			<p>Email: <a href="mailto:ippa@pkbi.or.id">ippa@pkbi.or.id</a></p>
			<p>Website: <a href="https://www.pkbi.or.id">www.pkbi.or.id</a></p>
			<div>
				<p>&copy; 2023</p>
			</div>
		</div>
	</div>
</footer>