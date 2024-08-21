<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Password"); form.b.focus(); return (false); }									
		if (form.c.value == ""){ alert("Anda belum menuliskan Nama Lengkap"); form.c.focus(); return (false); }
		if (form.d.value == ""){ alert("Anda belum menuliskan Email"); form.d.focus(); return (false); }
// 		if (form.e.value == ""){ alert("Anda belum menuliskan No Telpon"); form.e.focus(); return (false); }																		
	  return (true);
	}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style3 {color: #FF0000; font-weight: bold; }
-->
</style>
	

<div class="row container">
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?>		</div>
		<h2><?php echo "$title"; ?></h2>
		<h3>Syarat dan Ketentuan</h3>
			"Dengan mengisi formulir registrasi ini, Saya menyatakan bersedia berpartisipasi dalam proses konsultasi online untuk menceritakan permasalahan dan kehidupan pribadi secara sukarela tanpa ada paksaan dan atau untuk melakukan rangkaian proses konsultasi online.<br><br>
			<span class="style3">(*)</span></label> 
			Mohon Dilengkapi <br>
			<br />
			

		<?php echo $this->session->flashdata('message'); ?>
		<form action="<?php echo base_url(); ?>user/pendaftaran" enctype='multipart/form-data' method="POST" class="form-horizontal" onSubmit="return validasireg(this)">
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Nama Depan<span class="style1">*</span></label>
		    <div class="col-sm-10">
			
		      <input type="text" name='c' class="form-control" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Nama Belakang<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="text" name='cc' class="form-control" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Kelamin<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="radio" name='kelamin' value='Laki-laki' checked> Laki-laki
		      <input type="radio" name='kelamin' value='Perempuan'> Perempuan
		      <input type="radio" name='kelamin' value='Lainnya'> Lainnya		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Tempat Lahir</label>
		    <div class="col-sm-10">
		      <input type="text" name='tempat_lahir' class="form-control">
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Lahir<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="text" name='tanggal_lahir' class="form-control datepicker" autocomplete='off' data-date-format="dd-mm-yyyy" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Status<span class="style1">*</span></label>
		    <div class="col-sm-10">
			    <select class="form-control" name='status' required>
			    	<option value=''>- Pilih -</option>
			    <?php 
			    	$status = array('Kawin','Belum Kawin','Duda / Janda');
			    	for ($i=0; $i < count($status); $i++) { 
			    		echo "<option value='".$status[$i]."'>".$status[$i]."</option>";
			    	}
			    ?>
		      </select>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Agama<span class="style1">*</span></label>
		    <div class="col-sm-10">
			    <select class="form-control" name='agama' required>
			    	<option value=''>- Pilih -</option>
			    <?php 
			    	$agama = array('Islam','Kristen','Hindu','Buddha','Katolik','Khonghucu','Lainnya');
			    	for ($i=0; $i < count($agama); $i++) { 
			    		echo "<option value='".$agama[$i]."'>".$agama[$i]."</option>";
			    	}
			    ?>
		      </select>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Alamat</label>
		    <div class="col-sm-10">
		      <textarea name='alamat' class="form-control"></textarea>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">No Telpon</label>
		    <div class="col-sm-10">
		      <input type="number" name='e' class="form-control" maxlength="15"  onkeyup="nospaces(this)">
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Alamat Email<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="email" name='d' class="form-control"  onkeyup="nospaces(this)" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
		    <div class="col-sm-10">
		      <input type="text" name='perangkat_daerah' class="form-control" value="Klien" disabled required>
		    </div>
		  </div>
		  

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Username<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="text" name='a' class="form-control" maxlength="50"  onkeyup="nospaces(this)" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Password<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="password" name='b' class="form-control" onkeyup="nospaces(this)" maxlength="50" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password<span class="style1">*</span></label>
		    <div class="col-sm-10">
		      <input type="password" name='bb' class="form-control" onkeyup="nospaces(this)"  maxlength="50" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Foto</label>
		    <div class="col-sm-10">
		      <input type="file" name='f' class="form-control" maxlength="50">
		      <small style='font-weight:normal'><i>Allowed File : gif, jpg, png, jpeg</i></small>		    </div>
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
		      <button type="submit" name='submit' class="btn btn-primary">Submit</button>
		      <button type="reset" class="btn btn-success">Batal</button>
		    </div>
		  </div>
		</form>
	</div>
</div>