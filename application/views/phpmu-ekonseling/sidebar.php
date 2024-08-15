<?php 
$query = $this->db->query("SELECT * FROM users where username='".$this->session->username."'");
if ($query->num_rows()>=1 AND $this->uri->segment(1)=='user'){
  $usr = $query->row_array();
  if (trim($usr['foto'])==''){
    $foto_user = 'users.gif'; 
  }else{
    $foto_user = $usr['foto']; 
  }

  $tentang = strip_tags($usr['alamat_lengkap']); 
  echo "<br><table class='table'>
          <tr>
            <td><img  width='85px' height='85px' src='".base_url()."asset/foto_user/$foto_user' class='img-circle'><br> <center style='margin-top:3px'>(Klien)</center></td>
            <td><b>$usr[nama_lengkap]</b> <br><small style='color:red'>$usr[email]</small><br> <hr style='margin:3px'>
              $usr[jenis_kelamin]<br>
              $usr[no_telp]<br>
              $tentang.
            </td>
          </tr>
          <tr>
          <td colspan='2'>
            <a class='btn btn-block btn-xs btn-success' href='#uploadfoto' data-toggle='modal' data-target='#uploadfoto'>Ganti Foto</a>
            <a class='btn btn-block btn-xs btn-success' href='".base_url()."user/profile'>Lihat Profil</a>
            <a class='btn btn-block btn-xs btn-success' href='".base_url()."user/konsultasi'>Data Konsultasi</a>
			<a class='btn btn-block btn-xs btn-info' href='".base_url()."user/tambah-konsultasi'>Mulai Konsultasi</a>
          </td>
          </tr>
        </table>";
}
 ?>

<div style="clear:both"><br></div>
<?php
  $no = 1;
  $pasangiklan2 = $this->model_utama->view_ordering_limit('pasangiklan','id_pasangiklan','DESC',0,1);
  foreach ($pasangiklan2->result_array() as $b) {
	if ($b['gambar'] != ''){
		echo "<a href='$b[url]'><img src='".base_url()."asset/foto_pasangiklan/$b[gambar]' class='img-responsive'></a>";
	}
	$no++;
  }
?>





