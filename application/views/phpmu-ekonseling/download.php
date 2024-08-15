<div class="row container">
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?> 
		</div>

		<h2><?php echo $title; ?></h2>
		<article style="margin-top: 30px;">
			<table style='background:#fff; border-radius:6px;' class="table table-hover table-bordered">
			<thead>
				<tr bgcolor='#032739'>
					<th style='color:#fff'>No</th>
					<th style='color:#fff'>Nama File</th>
					<th style='color:#fff'>Hits</th>
					<th style='width:70px'></th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$no = $this->uri->segment(3)+1;
				foreach ($download->result_array() as $r) {	
				if(($no % 2)==0){ $warna="#ffffff";}else{ $warna="#E1E1E1"; }
					echo "<tr bgcolor=$warna>
							<td style='color:#000'>$no</td>
						  	<td style='color:#000'>$r[judul]</td>
						  	<td style='color:#000'>$r[hits] Kali</td>
						  	<td><a class='button' style='background:#29b332; color:#ffffff; padding:2px 10px' href='".base_url()."download/file/$r[nama_file]'>Download</a></td>
						  </tr></tbody>";
					$no++;
				}
			?>
		</table>
		</article>	
		<div style="clear:both"></div>
			<?php echo $this->pagination->create_links(); ?>	
	</div>
</div>
