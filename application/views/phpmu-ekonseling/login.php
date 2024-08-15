<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Password"); form.b.focus(); return (false); }									
		if (form.c.value == ""){ alert("Anda belum menuliskan Nama Lengkap"); form.c.focus(); return (false); }
		if (form.d.value == ""){ alert("Anda belum menuliskan Email"); form.d.focus(); return (false); }
		//if (form.e.value == ""){ alert("Anda belum menuliskan No Telpon"); form.e.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="row container" style='margin-bottom:200px'>
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?> 
		</div>
		<h2><?php echo "$title"; ?></h2><br>
		 		 
		<p style='font-weight:normal'><label for="c_name"><b style='color:red'>PENTING!</b></label> Silahkan login dengan email dan password anda!</p><br>
		<?php echo $this->session->flashdata('message'); ?>
		<form action="<?php echo base_url(); ?>user/login" method="POST" class="form-horizontal" onSubmit="return validasireg(this)">
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Masukan Username</label>
		    <div class="col-sm-8">
		      <input type="text" name='a' class="form-control" id="inputEmail3" placeholder="Username/Email">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Masukan Password</label>
		    <div class="col-sm-8">
		      <input type="password" name='b' class="form-control" id="inputPassword3" placeholder="Password">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		       
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" name='submit' class="btn btn-primary">Masuk</button>
		      <a href="<?php echo base_url(); ?>user/pendaftaran" class="btn btn-success">Pendaftaran</a>
		      
		    </div>
		  </div>
		</form>
	</div>
</div>