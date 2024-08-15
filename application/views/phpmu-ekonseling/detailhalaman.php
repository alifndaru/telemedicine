<?php
	$baca = $rows['dibaca']+1;	
?>	
<div class="row container">
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <a href="#" rel="category tag"><?php echo "$rows[nama_kategori]"; ?></a> » <?php echo "$rows[judul]"; ?> 
		</div>  
			<h1><?php echo "<b>$rows[judul]</b>"; ?></h1>
		   	<div id="autor">
		        <p style="text-transform: uppercase;">
			        <?php echo $rows['hari'].', '.tgl_indo($rows['tgl_posting'])." | $rows[jam] WIB"; ?>
		            
		        </p>
		    </div>
		    <hr/ style="margin-bottom: 0;">  
		  
			<div class="row">
				<div class="col-md-12 text-center">
					<figure style="background: #EAEAEA; padding-top: 5px;">
	                    <?php if ($rows['gambar'] !=''){ echo "<img class='img-responsive center-block' src='".base_url()."asset/foto_statis/$rows[gambar]' alt='$rows[judul]' />"; } ?>
                    </figure>
                    <div class="kepsen clearfix "></div> 
				</div>
			</div>
		  
			<article class="membaca">
		    	<?php 
		    		echo "$rows[isi_halaman]<hr>
					<div class='fb-like'  data-href='".base_url()."berita/detail/$rows[judul_seo]' 
						data-send='false'  data-width='600' data-show-faces='false'>
					</div>";
		    	?>
			</article>
	</div>
</div>