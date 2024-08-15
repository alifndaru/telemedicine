<div class="row container">
	<div class="col-md-12" style="padding-right: 10px;">
		<div style='padding:8px 0px' class="breadcrumb">
			<a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a> » Kategori » <?php echo "$rows[nama_kategori]"; ?> 
		</div>  
		<h2>Kategori "<?php echo "$rows[nama_kategori]"; ?>"</h2><br>
		<div class="row">
			<?php 
				foreach ($beritakategori->result_array() as $pi) {	
				$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $pi['id_berita'],'aktif'=>'Y'))->num_rows();
				$tgl = tgl_indo($pi['tanggal']);
				$isi_berita =(strip_tags($pi['isi_berita'])); 
			  	$isi = substr($isi_berita,0,500); 
			  	$isi = substr($isi_berita,0,strrpos($isi," ")); 
				  echo "<div class='col-md-12'>
							<h4 class='title-list'>
								<a href='".base_url()."berita/detail/$pi[judul_seo]' rel='bookmark' title='$pi[judul]'>$pi[judul]</a>
							</h4>
							
							<p class='newsdate' style='font-size: 11px;'>
								<span class='glyphicon glyphicon-calendar'></span> $pi[jam], $tgl | ".cek_terakhir($pi['tanggal'].' '.$pi['jam'])." Lalu, <span class='glyphicon glyphicon-comment'></span> $total_komentar Komentar
								<span class='pull-right text-danger'>$pi[dibaca] View</span>
							</p>
							<div class='just'>
							<p>$isi...</p>
							</div>
						</div>";
				}
			?>
		</div>	
		<div style="clear:both"></div>
			<?php echo $this->pagination->create_links(); ?>	
	</div>
</div>
