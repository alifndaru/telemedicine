<?php 
echo "<h3 id='title-footer-address'><span>Provider Kami</span></h3>
<table class='table table-condensed table-hover'>";
$no = 0; 
$users = $this->db->query("SELECT * FROM users where level='user' ORDER BY username DESC LIMIT 5");
foreach ($users->result_array() as $row){
if (trim($row['foto'])==''){ $foto = "users.gif"; }else{ $foto = $row['foto']; }
if ($no%2==0){ $color = '#e3e3e3'; }else{ $color = '#fff'; }
echo "<tr bgcolor='$color'>
        <td width='55px'><img style='width:55px' class='img-circle' src='".base_url()."asset/foto_user/$foto'></td>
        <td><span style='text-transform:capitalize'><b>$row[nama_lengkap]</b></span> 
          <br>$row[perangkat_daerah]<br>
          <small>$row[email]</small>
        </td>
      </tr>";
  $no++;
} 
echo "</table><div style='clear:both'></div>";
?>

<div class='hidden-xs panel-background'>
<ul class="nav nav-tabs" role="tablist" style='background: #fff;'>
	<li role="presentation" class="active"><a href="#panel1" aria-controls="panel1" role="tab" data-toggle="tab">UTAMA</a></li>
	<li role="presentation"><a href="#panel2" aria-controls="panel2" role="tab" data-toggle="tab">PILIHAN</a></li>
	<li role="presentation"><a href="#panel3" aria-controls="panel3" role="tab" data-toggle="tab">POPULER</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
<div role="tabpanel" class="tab-pane active panel-modifikasi" id="panel1">
<?php 
	$no = 1;
	$utama = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('status' => 'Y','utama' => 'Y'),'id_berita','DESC',0,8);
	foreach ($utama->result_array() as $row) {	
	$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita']))->num_rows();
	$tgl = tgl_indo($row['tanggal']);
	$isi_berita =(strip_tags($row['isi_berita'])); 
  	$isi = substr($isi_berita,0,200); 
  	$isi = substr($isi_berita,0,strrpos($isi," ")); 
	echo "<div><h1 class='pull-left'>$no</h1>
			<p class='date-list'>$row[hari], $tgl, $row[jam]</p>
			<h5 class='title-list-sidebar'>
				<a style='color:#fff' href='".base_url()."berita/detail/$row[judul_seo]' rel='bookmark' title='$row[judul]'>$row[judul]</a>
			</h5>
	</div>
	<div style='clear:both'><hr style='margin:7px; border:1px dotted #013246'></div>";
		$no++;
	}
?>		 
</div>

<div role="tabpanel" class="tab-pane panel-modifikasi" id="panel2">
<?php 
	$no = 1;
	$pilihan = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('status' => 'Y','berita.aktif' => 'Y'),'id_berita','DESC',0,8);
	foreach ($pilihan->result_array() as $row) {	
	$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita']))->num_rows();
	$tgl = tgl_indo($row['tanggal']);
	$isi_berita =(strip_tags($row['isi_berita'])); 
  	$isi = substr($isi_berita,0,200); 
  	$isi = substr($isi_berita,0,strrpos($isi," ")); 
	echo "<div><h1 class='pull-left'>$no</h1>
			<p class='date-list'>$row[hari], $tgl, $row[jam]</p>
			<h5 class='title-list-sidebar'>
				<a style='color:#fff' href='".base_url()."berita/detail/$row[judul_seo]' rel='bookmark' title='$row[judul]'>$row[judul]</a>
			</h5>
	</div>
	<div style='clear:both'><hr style='margin:7px; border:1px dotted #013246'></div>";
		$no++;
	}
?>		
</div>

<div role="tabpanel" class="tab-pane panel-modifikasi" id="panel3">
<?php 
	$no = 1;
	$populer = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('status' => 'Y'),'dibaca','DESC',0,8);
	foreach ($populer->result_array() as $row) {	
	$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita']))->num_rows();
	$tgl = tgl_indo($row['tanggal']);
	$isi_berita =(strip_tags($row['isi_berita'])); 
  	$isi = substr($isi_berita,0,200); 
  	$isi = substr($isi_berita,0,strrpos($isi," ")); 
  	echo "<div><h1 class='pull-left'>$no</h1>
			<p class='date-list'>$row[hari], $tgl, $row[jam]</p>
			<h5 class='title-list-sidebar'>
				<a style='color:#fff' href='".base_url()."berita/detail/$row[judul_seo]' rel='bookmark' title='$row[judul]'>$row[judul]</a>
			</h5>
	</div>
	<div style='clear:both'><hr style='margin:7px; border:1px dotted #013246'></div>";
		$no++;
	}
?>	
</div>
</div>
</div>




