<div class="row container">
	<div class="col-md-12" style="margin-top: 30px;">
		<h4 class="rubrikdecs">BERITA TERKINI</h4>
	</div>
	
	<div class="row">
		<div class="col-md-12"> 	
		<?php 
			$no = 1;
			$terkini = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('status' => 'Y'),'id_berita','DESC',0,4);
			foreach ($terkini->result_array() as $row) {	
			$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita']))->num_rows();
			$tgl = tgl_indo($row['tanggal']);
			$isi_berita =(strip_tags($row['isi_berita'])); 
		  	$isi = substr($isi_berita,0,255); 
		  	$isi = substr($isi_berita,0,strrpos($isi," ")); 
				echo "<div class='col-md-6'>
				   		<div class='col-md-12 list-news'>
							<div class='thumb' style='height:210px; overflow:hidden'>";
								if ($row['gambar'] ==''){
									echo "<a class='hover-effect' href='".base_url()."berita/detail/$row[judul_seo]'><img class='img-responsive img-thumbnail' src='".base_url()."asset/foto_berita/no-image.jpg' alt='$row[judul]' /></a>";
								}else{
									echo "<a class='hover-effect' href='".base_url()."berita/detail/$row[judul_seo]'><img class='img-responsive img-thumbnail' src='".base_url()."/asset/foto_berita/$row[gambar]' alt='$row[judul]' /></a>";
								}
							echo "</div>
					   		<h4 class='title-list' style='padding: 0 10px;'>
						   		<a href='".base_url()."berita/detail/$row[judul_seo]' rel='bookmark' title='$row[judul]'>$row[judul]</a>
						   	</h4>
							<p class='date-list' style='padding: 0 10px;'>$row[hari], $tgl | $row[jam]</p>
				   		</div>
				   		<div class='just'>
							<p>$isi...</p>
						</div>
						<a class='pull-right' href='".base_url()."berita/detail/$row[judul_seo]'>Lihat Berita selengkapnya...</a>
						<div style='clear:both'><br></div>
			   		 </div>";
				$no++;
			}
		?>				 
			<!-- end article -->	
		</div>
	</div>
</div>