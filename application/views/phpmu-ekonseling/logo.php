<div class="wrapper container">
	<div class="col-md-6 col-sm-12">
	<?php
		$iden = $this->model_utama->view('identitas')->row_array(); 
	?>
	</div>
	<div class="col-md-6 col-sm-12 pull-right right-content">
    <?php
    	$attributes = array('class'=>'cari pull-right hidden-xs','id'=>'searchform');
    	echo form_open('berita/index',$attributes); ?>
			<input type="text" value="" name="kata" class="input" placeholder='Search...'/>
			<input class="button" style="padding: 0;" name='cari' value="GO" type="submit"/>
		</form>			
	<p class="visi pull-right hidden-sm hidden-xs">"<?php echo $iden['meta_deskripsi']; ?>"</p>
	
	</div>
</div>