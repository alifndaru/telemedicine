<div class="row container">
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> &raquo; Daftar Provider
		</div>

	<h2>Daftar Provider Seluruh Indonesia</h2>
		<p>Silahkan <b><a href="http://localhost/telemedic/user/login">Login</a></b> atau melakukan <b><a href="http://localhost/telemedic/user/pendaftaran">Pendaftaran</a></b> terlebih dulu untuk melakukan  <a href="<?=base_url('user/tambah-konsultasi'); ?>" class="btn btn-sm btn-success">Mulai Konsultasi <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		
	<form action="<?=base_url('/psikolog/lists');?>"method="post">
	
			<input style="width:1112px; height:40px; font-size:20px;" input type="text" name="dokter" class="form-control" value="" placeholder="Masukkan Nama Provider Yang Ingin Dicari..." autocomplete='off'>
			</form>	
		
		<article style="margin-top: 30px;">
			<?php 
				echo "";
				$no = 0; 
				foreach ($psikolog->result_array() as $row){
				if (trim($row['foto'])==''){ $foto = "users.gif"; }else{ $foto = $row['foto']; }
				if ($no%2==1){ $color = '#e3e3e3'; }else{ $color = '#fff'; }
				echo "<div class='col-md-6 col-sm-6' style='margin-bottom:10px; display: inline-flex;'>
				        <img style='width:65px; height:65px; float:left; margin-right:10px' class='img-circle' src='".base_url()."asset/foto_user/$row[foto_dokter]'>
				        <div style='display: inline-block;float: right;}'>
						  Nama: <span style='text-transform:capitalize'><b style='color:red'>$row[nama_lengkap]</b></span><br>
				          Jabatan: <span style='color:#000'>$row[jabatan]</span><br>
						  Daerah: <span style='color:#000'>$row[klinik]</span><br>
						  Alamat: <span style='color:#000'>$row[alamat_klinik], $row[provinsi]</span><br>
				          Jenis Kelamin: <small style='color:#000'>$row[gender]</small><br>
						  No. SIP: <small style='color:#000'>$row[sip]</small><br>
						  No. STR: <small style='color:#000'>$row[str]</small>
						</div>
						  	
						 
				     </div>";
				  $no++;
				} 
				echo "<div style='clear:both'></div>";
				?>
		</article>	
		<div style="clear:both"></div>
			<?php echo $this->pagination->create_links(); ?>	
	</div>
</div>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
