<div class="wrapper container">
	<div class="row">
		<?php 
			$no = 1;
			$menubawah = $this->model_app->view('menu_statis');
			foreach ($menubawah->result_array() as $row) {
			if ($no==5){ $class='lasting';  }else{  $class='lasting'; }
			echo "<a href='$row[url]' style='color: #ffffff;'>
					<div class='col-md-15 nav-middle text-center $class'>
						$row[judul]<br>
						<span>$row[keterangan]</span>
					</div>
				  </a>";
				$no++;
			}
		?>
	</div>	
</div>  