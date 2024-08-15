<div class="row container">
	<div class="col-md-8 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » Profil Klien
		</div>
		<h2>Profil Klien </h2>
		<br>
		
		<p style='font-weight:normal'><label for="c_name"><b style='color:red'>PENTING!</b></label>Pastikan data anda dibawah ini sesuai dengan data kartu identitas, dan bisa dipertanggung jawabkan jika nanti ada masalah. Terima kasih</p><br>
		<a href='<?php echo base_url(); ?>user/edit_profile' class='btn btn-xs btn-warning pull-right'>Edit Profile</a>
		<dl class="dl-horizontal">
            <dt>Username</dt>		<dd><?php echo $row['username']; ?></dd>
            <dt>Password</dt>		<dd>***********************</dd>
            <dt>Nama Lengkap</dt>		<dd><?php echo $row['nama_lengkap']; ?></dd>
            <dt>Alamat Email</dt>		<dd><?php echo $row['email']; ?></dd>
            <dt>No Telpon</dt>		<dd><?php echo $row['no_telp']; ?></dd>
            <dt>Jenis Kelamin</dt>		<dd><?php echo $row['jenis_kelamin']; ?></dd>
            <dt>Alamat Lengkap</dt>		<dd><?php echo $row['alamat_lengkap']; ?></dd>
            <dt>Tempat Lahir</dt>		<dd><?php echo $row['tempat_lahir']; ?></dd>
            <dt>Tanggal Lahir</dt>   <dd><?php echo $row['tanggal_lahir']; ?></dd>
            <dt>Status</dt>   <dd><?php echo $row['status_kawin']; ?></dd>
            <dt>Agama</dt>   <dd><?php echo $row['agama']; ?></dd>
            <dt>Status</dt>   
            <dd><?php echo nl2br($row['perangkat_daerah']); ?></dd>
		</dl>
            <!-- <a class='btn btn-sm btn-block btn-default' href='<?php echo base_url(); ?>user/konsultasi'><b>Konsultasi Sekarang!</b></a><br> -->
	</div>


	<div class="col-md-4 sidebar col-sm-12">
		<?php include "sidebar.php"; ?>
	</div>
</div>