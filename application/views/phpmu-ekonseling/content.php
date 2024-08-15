<div style="clear:both"><br></div>
<div class="row container">
	<div id="mc_embed_signup">
		<?php echo form_open('berita/index'); ?>
	        <div class="input-group input-group-lg">
	            <input type="text" name="kata" class="form-control" value="" placeholder="Masukkan Topic yang anda cari disini..." autocomplete='off'>
	            <span class="input-group-btn">
	                <button type="submit" name='cari' class="btn btn-success"><i class="fa fa-search fa-fw visible-xs"></i> <span class="hidden-xs">Search</span></button>
	            </span>
	        </div>
	    </form>
  	</div><br>

	<div class="col-md-8" style="padding-right: 10px;">
    	<div class="row">
			<?php 
				$no = 1;
				foreach ($berita->result_array() as $row) {	
				$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita'],'aktif'=>'Y'))->num_rows();
				$tgl = tgl_indo($row['tanggal']);
				$isi_berita =(strip_tags($row['isi_berita'])); 
			  	$isi = substr($isi_berita,0,500); 
			  	$isi = substr($isi_berita,0,strrpos($isi," ")); 
				echo "<div class='col-md-12'>
					   	<h4 class='title-list'>
						   	<a href='".base_url()."berita/detail/$row[judul_seo]' rel='bookmark' title='$row[judul]'>$row[judul]</a>
						</h4>
						<p class='newsdate' style='font-size: 11px;'>
							<span class='glyphicon glyphicon-calendar'></span> $row[hari], $tgl | $row[jam], <span class='glyphicon glyphicon-comment'></span> $total_komentar Komentar , <a class='btn btn-success btn-xs' href='".base_url()."kategori/detail/$row[kategori_seo]'>$row[nama_kategori]</a>
							<span class='pull-right text-danger'>$row[dibaca] View</span>
						</p>
				   		
					   	<div class='just'>
							<p>$isi...</p>
						</div>
						<div style='clear:both'><br></div>
					  </div>";
					$no++;
				}
			?>				 
		</div>
		<div style="clear:both"></div>
			<?php echo $this->pagination->create_links(); ?>	
	</div>
	
	<div class="col-md-4" style="padding-right: 10px;">
	       <?php include "sidebar_kiri.php"; ?>
	</div>
</div>