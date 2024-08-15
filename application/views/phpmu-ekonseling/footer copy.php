<div class="wrapper">
	<!-- <hr /> -->
	<div class="container">
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-12 col-sm-12" style='padding-right: 10px; padding-left: 15px;'>
				<!-- <h3 id="title-footer-address"><span>Media</span></h3> -->
				<!-- <br> -->
				<?php $mediax = (isset($identitas[0]['facebook'])) ? $identitas[0]['facebook'] : ""; ?>
				<?php $ex = explode(',', $mediax); ?>
				<div class="mediax">

				</div>
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-12" style='padding-right: 10px; padding-left: 15px;'>
				<h3 id="title-footer-address"><span><u>Login</u></span></h3>
				<?php
				$query = $this->db->query("SELECT * FROM users where username='" . $this->session->username . "'");
				if ($query->num_rows() >= 1 and $this->session->level != 'admin') {
					$usr = $query->row_array();
					if (trim($usr['foto']) == '') {
						$foto_user = 'users.gif';
					} else {
						$foto_user = $usr['foto'];
					}

					$tentang = strip_tags($usr['alamat_lengkap']);
					echo "<table class='table'>
						<tr>
							<td><img  width='85px' height='85px' src='" . base_url() . "asset/foto_user/$foto_user' class='img-circle'><br> <center style='margin-top:3px'>($usr[level])</center></td>
							<td><a href='" . base_url() . "user/profile'><b>$usr[nama_lengkap]</b></a> <br><small style='color:red'>$usr[email]</small><br> <hr style='margin:3px'>
							$usr[jenis_kelamin]<br>
							$usr[no_telp]<br>
							$tentang.
							</td>
						</tr>
						</table>";
				} else {
					echo $this->session->flashdata('message'); ?>
					<form action="<?php echo base_url(); ?>user/login" method="POST" class="form-horizontal" onSubmit="return validasireg(this)">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Username</label>
							<div class="col-sm-8">
								<input type="text" name='a' class="form-control" id="inputEmail3" placeholder="Username/Email">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-3 control-label">Password</label>
							<div class="col-sm-8">
								<input type="password" name='b' class="form-control" id="inputPassword3" placeholder="Password">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" name='submit' class="btn btn-primary">Sign in</button>
								<a href="<?php echo base_url(); ?>user/pendaftaran" class="btn btn-success">Registrasi</a>
							</div>
						</div>
					</form>
				<?php } ?>
			</div>

			<div class="col-md-4 col-sm-12" style='padding-right: 10px; padding-left: 15px;'>
				<h3 id="title-footer-address"><span><u>Kategori</u></span></h3>
				<ol style='margin-right:20px; margin-left: -7px;'>
					<?php
					$kategori = $this->model_utama->view_ordering_limit('kategori', 'id_kategori', 'DESC', 0, 5);
					foreach ($kategori->result_array() as $r) {
						echo "<li style='padding:2px 0px;'><a href='" . base_url() . "kategori/detail/$r[kategori_seo]'>$r[nama_kategori]</a></li>";
						$no++;
					}
					?>
				</ol>
			</div>

			<div class="col-md-4 col-sm-12" style='padding-right: 10px; padding-left: 15px;'>
				<h3 id="title-footer-address"><span><u>Unduh</u></span></h3>
				<ol style='margin-right:20px; margin-left: -7px;'>
					<?php
					$download = $this->model_utama->view_ordering_limit('download', 'id_download', 'DESC', 0, 5);
					foreach ($download->result_array() as $r) {
						echo "<li style='padding:2px 0px;'><a href='" . base_url() . "download/file/$r[nama_file]'>$r[judul]</a></li>";
						$no++;
					}
					?>
				</ol>
			</div>
		</div>
	</div>
</div>