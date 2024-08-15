<div class="row container">
	<div class="col-md-8 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?> 
		</div>
		<h2><?php echo "$title"; ?></h2><br>
		 		 
		<?php echo $this->session->flashdata('message');
		echo "<form action='".base_url()."user/konsultasi_edit' enctype='multipart/form-data' method='POST' class='form-horizontal' onSubmit='return validasireg(this)'>
		  <input type='hidden' name='id' value='$rows[id_konsul]'>
		  <div class='form-group'>
		    <label for='inputEmail3' class='col-sm-3 control-label'>Kategori</label>
		    <div class='col-sm-9'>
		    	<select name='a' class='form-control' required>
                <option value='' selected>- Pilih Kategori Inovasi -</option>";
                foreach ($kategori as $row){
                	if ($row['id_kategori_konsul']==$rows['id_kategori_konsul']){
	                    echo "<option value='$row[id_kategori_konsul]' selected>$row[nama_kategori]</option>";
	                }else{
	                	echo "<option value='$row[id_kategori_konsul]'>$row[nama_kategori]</option>";
	                }
                }
                echo "</select>
		    </div>
		  </div>
		  <div class='form-group'>
		    <label for='inputPassword3' class='col-sm-3 control-label'>Judul</label>
		    <div class='col-sm-9'>
		      <input type='text' name='b' class='form-control' value='$rows[judul]' required>
		    </div>
		  </div>

		  <div class='form-group'>
		    <label for='inputEmail3' class='col-sm-3 control-label'>Deskripsi</label>
		    <div class='col-sm-9'>
		      <textarea name='h' class='form-control textarea' required>$rows[isi_konsul]</textarea>
		    </div>
		  </div>

		  <br>
		  <div class='form-group'>
		    <div class='col-sm-offset-2 col-sm-10'>
		      <button type='submit' name='submit' class='btn btn-primary'>Update Data</button>
		      <a href='".base_url()."user/konsultasi' class='btn btn-default'>Kembali ke-Awal</a>
		    </div>
		  </div>
		</form>
	</div>


	<div class='col-md-4 sidebar col-sm-12'>";
		include "sidebar.php";
	echo "</div>
</div>";