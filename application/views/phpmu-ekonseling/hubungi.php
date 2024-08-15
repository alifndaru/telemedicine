<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Password"); form.b.focus(); return (false); }									
		if (form.c.value == ""){ alert("Anda belum menuliskan Nama Lengkap"); form.c.focus(); return (false); }
		if (form.d.value == ""){ alert("Anda belum menuliskan Email"); form.d.focus(); return (false); }
		if (form.e.value == ""){ alert("Anda belum menuliskan No Telpon"); form.e.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="row container">
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?> 
		</div>
		<!-- <h2><?php echo "$title"; ?></h2><br> -->
		<!-- <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo "$iden[maps]"; ?>"></iframe> 		 
		<br><br>

		<div class="col-md-6 col-sm-6 clearfix">
			<?php echo "$rows[alamat]";?>
		</div> -->

		<div class="col-md-6 col-sm-6 clearfix">
			<h3>Kirim saran</h3>
			<br>
			<?php if ($this->session->flashdata('message')){ echo "<div class='alert alert-success'>".$this->session->flashdata('message')."</div>"; } ?>
			<form action="<?php echo base_url(); ?>hubungi/kirim" method="POST" class="comment-form" id="form_komentar commentform">
				<p class="contact-form-user">
					<label for="c_name">Nama<span class="required">*</span></label>
					<input type="text" name='a' id="c_name" required>
				</p>
				<p class="contact-form-email">
					<label for="c_email">Surel<span class="required">*</span></label>
					<input type="email" name='b' id="c_email" required>
				</p>
				<p class="contact-form-message">
					<label for="c_message">Pesan<span class="required">*</span></label>
					<textarea style='min-height:100px' cols="25" rows="3" name='c' id="c_message" required></textarea>
				</p>
				<p class="contact-form-message">
					<label for="c_message">
					<?php echo $image; ?><br></label>
					<input name='secutity_code' maxlength=6 type="text" class="required" placeholder="Masukkkan kode di sebelah kiri..">
				</p>
				<p><input type="submit" name="submit" class="styled-button" value="Kirim pesan" onclick="return confirm('Pesan anda ini akan kami balas melalui email ?')"/></p>
			</form>
		</div>
	</div>
</div>
