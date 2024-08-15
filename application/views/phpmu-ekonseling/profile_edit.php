<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username"); form.a.focus(); return (false); }								
		if (form.c.value == ""){ alert("Anda belum menuliskan Nama Lengkap"); form.c.focus(); return (false); }
		if (form.d.value == ""){ alert("Anda belum menuliskan Email"); form.d.focus(); return (false); }
// 		if (form.e.value == ""){ alert("Anda belum menuliskan No Telpon"); form.e.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="row container">
	<div class="col-md-8 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?> 
		</div>
		<h2><?php echo "$title"; ?></h2><br>
		 		 
		<p style='font-weight:normal'><label for="c_name"><b style='color:red'>PENTING!</b></label> Silahkan Mengisi form dibawah ini dengan data yang sebenarnya. Terima kasih,..</p><br>
		<?php 
			echo $this->session->flashdata('message'); 
			$nama = explode(' ', $row['nama_lengkap']);
		?>
		<form action="<?php echo base_url(); ?>user/edit_profile" enctype='multipart/form-data' method="POST" class="form-horizontal" onSubmit="return validasireg(this)">
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
		    <div class="col-sm-10">
		      <input type="text" name='a' class="form-control" placeholder="Username" value='<?php echo $row['username']; ?>' maxlength="50"  onkeyup="nospaces(this)" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
		    <div class="col-sm-10">
		      <input type="password" name='b' class="form-control" placeholder="*****************"  maxlength="50">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Nama Depan</label>
		    <div class="col-sm-10">
		      <input type="text" name='c' class="form-control" value='<?php echo $nama[0]; ?>' required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Nama Belakang</label>
		    <div class="col-sm-10">
		      <input type="text" name='cc' class="form-control" value='<?php echo $nama[1].$nama[2].$nama[3]; ?>' required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Alamat Email</label>
		    <div class="col-sm-10">
		      <input type="email" name='d' class="form-control" placeholder="nama_anda@mail.com" value='<?php echo $row['email']; ?>'  onkeyup="nospaces(this)" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">No Telpon</label>
		    <div class="col-sm-10">
		      <input type="number" name='e' class="form-control" placeholder="08XXXXXXXXXX" value='<?php echo $row['no_telp']; ?>' maxlength="15"  onkeyup="nospaces(this)">
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Kelamin</label>
		    <div class="col-sm-10">
			    <?php if ($row['jenis_kelamin']=='Laki-laki'){ ?>
			      <input type="radio" name='kelamin' value='Laki-laki' checked> Laki-laki
			      <input type="radio" name='kelamin' value='Perempuan'> Perempuan
			      <input type="radio" name='kelamin' value='Lainnya'> Lainnya
			    <?php } elseif ($row['jenis_kelamin']=='Perempuan') { ?>
			      <input type="radio" name='kelamin' value='Laki-laki'> Laki-laki
			      <input type="radio" name='kelamin' value='Perempuan' checked> Perempuan
			      <input type="radio" name='kelamin' value='Lainnya'> Lainnya
			    <?php } else { ?>
			        <input type="radio" name='kelamin' value='Laki-laki'> Laki-laki
			        <input type="radio" name='kelamin' value='Perempuan'> Perempuan
			        <input type="radio" name='kelamin' value='Lainnya' checked> Lainnya
			    <?php } ?>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Alamat</label>
		    <div class="col-sm-10">
		      <textarea name='alamat' class="form-control"><?php echo $row['alamat_lengkap']; ?></textarea>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Tempat Lahir</label>
		    <div class="col-sm-10">
		      <input type="text" name='tempat_lahir' class="form-control" value='<?php echo $row['tempat_lahir']; ?>'>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Lahir</label>
		    <div class="col-sm-10">
		      <input type="text" name='tanggal_lahir' class="form-control datepicker" autocomplete='off' data-date-format="dd-mm-yyyy" value='<?php echo $row['tanggal_lahir']; ?>' required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
		    <div class="col-sm-10">
		      <select class="form-control" name='status' required>
			    <?php 
			    	$status = array('Kawin','Belum Kawin','Duda / Janda');
			    	for ($i=0; $i < count($status); $i++) { 
			    		if ($row['status_kawin']==$status[$i]){
			    			echo "<option value='".$status[$i]."' selected>".$status[$i]."</option>";
			    		}else{
			    			echo "<option value='".$status[$i]."'>".$status[$i]."</option>";
			    		}
			    	}
			    ?>
			     </select>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Agama</label>
		    <div class="col-sm-10">
		      <select class="form-control" name='agama' required>
			    <?php 
			    	$agama = array('Islam','Kristen','Hindu','Buddha','Katolik','Khonghucu','Lainnya');
			    	for ($i=0; $i < count($agama); $i++) { 
			    		if ($row['agama']==$agama[$i]){
			    			echo "<option value='".$agama[$i]."' selected>".$agama[$i]."</option>";
			    		}else{
				    		echo "<option value='".$agama[$i]."'>".$agama[$i]."</option>";
				    	}
			    	}
			    ?>
			     </select>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
		    <div class="col-sm-10">
		      <input type="text" name='perangkat_daerah' class="form-control" value='<?php echo $row['perangkat_daerah']; ?>' disabled required>
		    </div>
		  </div>

		  <!--<div class="form-group">-->
		  <!--  <label style='padding-top: 0px;' for="inputEmail3" class="col-sm-2 control-label"><?php echo $image; ?></label>-->
		  <!--  <div class="col-sm-10">-->
		  <!--    <input name='secutity_code' maxlength=6 class="form-control" placeholder="Masukkkan kode di sebelah kiri.." maxlength="50"  onkeyup="nospaces(this)" required>-->
		  <!--  </div>-->
		  <!--</div>-->

		  <br>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" name='submit' class="btn btn-primary">Simpan Perubahan</button>
		      <a href="<?php echo base_url(); ?>user/profile" class="btn btn-default">Batal</a>
		    </div>
		  </div>
		</form>
	</div>


	<div class="col-md-4 sidebar col-sm-12">
		<?php include "sidebar.php"; ?>
	</div>
</div>