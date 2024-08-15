<?php
	$total_komentar = $this->model_utama->view_where('komentar_konsul',array('id_konsul' => $rows['id_konsul'],'aktif'=>'Y'))->num_rows();
?>	
<div class="row container">
<div class="col-md-12 col-sm-12 clearfix">
<div class="breadcrumb">
	<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » Konsultasi » <?php echo "$rows[judul]"; ?> 
</div>  
	<h1><?php echo "<b>$rows[judul]</b>"; ?></h1>
   	<div id="autor">
        <p style="text-transform: uppercase;">
	        <?php echo $rows['hari'].', '.tgl_indo($rows['tanggal'])." | $rows[jam] WIB - Oleh $rows[nama_lengkap]"; ?>

	        <div class='addthis_toolbox addthis_default_style'>
              <a class='addthis_button_preferred_1'></a>
              <a class='addthis_button_preferred_2'></a>
              <a class='addthis_button_preferred_3'></a>
              <a class='addthis_button_preferred_4'></a>
              <a class='addthis_button_compact'></a>
              <a class='addthis_counter addthis_bubble_style'></a>
          </div>
          <script type='text/javascript' src='http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f8aab4674f1896a'></script>
		</p>
    </div>
  
	<article class="membaca">
    	<?php 
    		echo "$rows[isi_konsul]<hr>
			<div class='fb-like'  data-href='".base_url()."berita/detail/$rows[judul_seo]' 
				data-send='false'  data-width='600' data-show-faces='false'>
			</div><br><br>";
    	?>
	</article>	

<?php
	echo "<div>";
  		if ($total_komentar>='1'){ ?>
	        <div id='listcomment' class='alert alert-danger hidden-xs'><?php echo "Ada $total_komentar Komentar"; ?></div>
	        <ul class="media-list comment-list">
	            <?php
	              $no = 1;
                if ($this->session->level!='inovator'){
                  $komentar = $this->model_utama->view_where_ordering_limit('komentar_konsul',array('id_konsul' => $rows['id_konsul']),'id_komentar','ASC',0,100);
                }else{
                  $komentar = $this->model_utama->view_where_ordering_limit('komentar_konsul',array('id_konsul' => $rows['id_konsul'],'aktif' => 'Y'),'id_komentar','ASC',0,100);
                }
	                foreach ($komentar->result_array() as $rows) {
	                $isian=nl2br($rows['isi_komentar']); 
	                $komentarku = $isian; 
	                $test = md5(strtolower(trim($rows['email']))); 
                  if ($rows['aktif']=='Y'){ $color = ''; $aktif = ''; }else{ $color='orange'; $aktif = '(Non Aktif)'; }
	                echo "<li class='media'>
	                        <div class='pull-left'>";
	                        if ($rows['email'] == ''){
	                          echo "<img style='width:60px; height:60px' class='media-object img-thumbnail img-circle' src='".base_url()."asset/foto_user/blank.png'/>";
	                        }else{
	                          echo "<img style='width:60px; height:60px' class='media-object img-thumbnail img-circle' src='http://www.gravatar.com/avatar/$test.jpg?s=100'/>";
	                        }
	                        echo "</div>
	                        <div>
	                          <strong class='user-nick'><a style='color:$color' href='#'>$rows[nama_komentar]</a> <small style='color:red'>$aktif</small></strong>, 
	                          <span class='time-stamp'>".tgl_indo($rows['tgl']).", $rows[jam_komentar] WIB</span><br>
	                          $komentarku
	                        </div>
	                      </li>"; 
	              }
	            ?>
	        </ul>
      	<?php 
      	} 
      echo $this->session->flashdata('message');
      if ($this->session->level!=''){
      ?>
        <div id='listcomment' class='alert alert-warning'>Tuliskan Komentar</div>
            <?php 
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open('konsultasi/kirim_komentar',$attributes); 
            ?>
              <input type="hidden" name='a' value='<?php echo "$rows[id_konsul]"; ?>'>
              <input type="hidden" class="form-control" placeholder="http://dowmiananda.com" name="c">

              <div class="form-group">
                <label for="inputPassword3" class="col-xs-3 control-label">Isi Komentar</label>
                <div style='background:#fff;' class="input-group col-xs-8">
                  <textarea name='d' style='height:120px' placeholder="Tuliskan Komentar disini.." class="form-control" required></textarea>
                </div>
              </div>

              <div class='form-group'>
                  <label for='inputEmail3' style='margin-top:-5px' class='col-xs-3 control-label'><?php echo $image; ?></label>
                  <div style='background:#fff;' class="input-group col-xs-8">
                      <input name='secutity_code' maxlength='6' type='text' class='form-control' placeholder='Masukkkan kode di sebelah kiri..'>
                  </div>
              </div>

            <div class="form-group">
              <div class="col-xs-offset-3">
                <input type="submit" name="submit" class="btn btn-success" value="Post a Comment" />
              </div>
            </div>
            
            </form>
		</div>	
    <?php 
      }else{
          echo "<div id='listcomment' class='alert alert-success'>Silahkan Login untuk Memberikan Komentar!</div>";
      }
    ?>
	</div>

</div>