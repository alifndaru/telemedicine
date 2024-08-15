<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data $rows[level]</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart('administrator/edit_manajemenuser',$attributes); 
              if ($rows['foto'] == ''){ $foto = 'users.gif'; } else { $foto = $rows['foto']; }
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$rows[username]'>
                    <input type='hidden' name='ids' value='$rows[id_session]'>
                    <tr><th width='140px' scope='row'>User ID</th>   <td><input type='text' class='form-control' name='a' value='$rows[user_id]' readonly='on'></td></tr>
                    <tr><th width='140px' scope='row'>Username</th>   <td><input type='text' class='form-control' name='a' value='$rows[username]' readonly='on'></td></tr>
                    <tr><th scope='row'>Password</th>                 <td><input type='password' class='form-control' name='b' onkeyup=\"nospaces(this)\"></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>             <td><input type='text' class='form-control' name='c' value='$rows[nama_lengkap]'></td></tr>
                    <tr><th scope='row'>Alamat Email</th>                    <td><input type='email' class='form-control' name='d' value='$rows[email]'></td></tr>
                    <tr><th scope='row'>No Telepon</th>                  <td><input type='number' class='form-control' name='e' value='$rows[no_telp]'></td></tr>
                    <tr><th scope='row'>Alamat Lengkap</th>                  <td><input type='text' class='form-control' name='alamat' value='$rows[alamat_lengkap]'></td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>                  <td><input type='text' class='form-control' name='tempat_lahir' value='$rows[tempat_lahir]'></td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>                  <td><input type='text' class='form-control' name='tanggal_lahir' value='$rows[tanggal_lahir]'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>                  <td>"; if ($rows['jenis_kelamin']=='Laki-laki'){
                                                                                  echo "<input type='radio' name='kelamin' value='Laki-laki' checked> Laki-laki
                                                                                        <input type='radio' name='kelamin' value='Perempuan'> Perempuan";
                                                                                }else{
                                                                                  echo "<input type='radio' name='kelamin' value='Laki-laki'> Laki-laki
                                                                                        <input type='radio' name='kelamin' value='Perempuan' checked> Perempuan";
                                                                                } echo "</td></tr>
                    <tr><th scope='row'>Status Kawin</th>                  <td><select class='form-control' name='status' required>";
                                                                                  $status = array('Kawin','Belum Kawin','Duda / Janda');
                                                                                  for ($i=0; $i < count($status); $i++) { 
                                                                                    if ($rows['status_kawin']==$status[$i]){
                                                                                      echo "<option value='".$status[$i]."' selected>".$status[$i]."</option>";
                                                                                    }else{
                                                                                      echo "<option value='".$status[$i]."'>".$status[$i]."</option>";
                                                                                    }
                                                                                  }
                                                                                 echo "</select></td></tr>
                    <tr><th scope='row'>Agama</th>                  <td><select class='form-control' name='agama' required>";
                                                                          $agama = array('Islam','Kristen','Hindu','Buddha','Katolik','Khonghucu','Lainnya');
                                                                          for ($i=0; $i < count($agama); $i++) { 
                                                                            if ($rows['agama']==$agama[$i]){
                                                                              echo "<option value='".$agama[$i]."' selected>".$agama[$i]."</option>";
                                                                            }else{
                                                                              echo "<option value='".$agama[$i]."'>".$agama[$i]."</option>";
                                                                            }
                                                                          }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Jabatan</th>                  <td><input type='text' class='form-control' name='perangkat_daerah' value='$rows[perangkat_daerah]'></td></tr>
                    <tr><th scope='row'>Ganti Foto</th>                     <td><input type='file' class='form-control' name='f'><hr style='margin:5px'>";
                                                                                 if ($rows['foto'] != ''){ echo "<i style='color:red'>Foto Saat ini : </i><a target='_BLANK' href='".base_url()."asset/foto_user/$rows[foto]'>$rows[foto]</a>"; } echo "</td></tr></td></tr>";
                    if ($this->session->level == 'admin'){
                      echo "<tr><th scope='row'>Status</th>                   <td>"; if ($rows['blokir']=='Y'){ echo "<input type='radio' name='h' value='Y' checked> Non Aktif &nbsp; <input type='radio' name='h' value='N'> Aktif"; }else{ echo "<input type='radio' name='h' value='Y'> Non Aktif &nbsp; <input type='radio' name='h' value='N' checked> Aktif"; } echo "</td></tr>";
                      
                      if ($rows['level'] != 'inovator'){
                      echo "<tr><th scope='row'>Tambah Akses</th>                    <td><div class='checkbox-scroll'>";
                                                                               foreach ($record as $row){
                                                                                 echo "<span style='display:block'><input name='modul[]' type='checkbox' value='$row[id_modul]' /> $row[nama_modul]</span> ";
                                                                               }
                      echo "</div></td></tr>
                      <tr><th scope='row'>Hak Akses</th>                    <td><div class='checkbox-scroll'>";
                                                                               foreach ($akses as $ro){
                                                                                 echo "<span style='display:block'><a class='text-danger' href='".base_url()."administrator/delete_akses/$ro[id_umod]/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-remove'></span></a> $ro[nama_modul]</span> ";
                                                                               }
                      echo "</div></td></tr>";
                      }
                    }
                  echo "</tbody>
                  </table></div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='index.php'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();