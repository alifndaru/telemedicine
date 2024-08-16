<?php
echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data User</h3>
                </div>
              <div class='box-body'>";
$attributes = array('class' => 'form-horizontal', 'role' => 'form');
echo form_open_multipart('administrator/tambah_manajemenuser', $attributes);
echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='140px' scope='row'>Username</th>   <td><input type='text' class='form-control' name='a' onkeyup=\"nospaces(this)\" required></td></tr>
                    <tr><th scope='row'>Password</th>                 <td><input type='password' class='form-control' name='b' onkeyup=\"nospaces(this)\" required></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>             <td><input type='text' class='form-control' name='c' required></td></tr>
                    <tr><th scope='row'>Alamat Email</th>             <td><input type='email' class='form-control' name='d' required></td></tr>
                    <tr><th scope='row'>No Telepon</th>               <td><input type='number' class='form-control' name='e' required></td></tr>
                    <tr><th scope='row'>Alamat Lengkap</th>           <td><input type='text' class='form-control' name='alamat'></td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>                  <td><input type='text' class='form-control' name='tempat_lahir'></td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>                  <td><input type='text' class='form-control' name='tanggal_lahir' value='00-00-0000'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>                  <td><input type='radio' name='kelamin' value='Laki-laki' checked> Laki-laki
                                                                                <input type='radio' name='kelamin' value='Perempuan' > Perempuan</td></tr>
                    <tr><th scope='row'>Status Kawin</th>                  <td><select class='form-control' name='status' required>";
$status = array('Kawin', 'Belum Kawin', 'Duda / Janda');
for ($i = 0; $i < count($status); $i++) {
  echo "<option value='" . $status[$i] . "'>" . $status[$i] . "</option>";
}
echo "</select></td></tr>
                    <tr><th scope='row'>Agama</th>                  <td><select class='form-control' name='agama' required>";
$agama = array('Islam', 'Kristen', 'Hindu', 'Buddha', 'Katolik', 'Khonghucu', 'Lainnya');
for ($i = 0; $i < count($agama); $i++) {
  echo "<option value='" . $agama[$i] . "'>" . $agama[$i] . "</option>";
}
echo "</select></td></tr>
                    <tr><th scope='row'>Jabatan</th>          <td><input type='text' class='form-control' name='perangkat_daerah'></td></tr>
                    <tr><th scope='row'>Spesialis</th>                <td><input type='text' class='form-control' name='spesialis'></td></tr>
                    <tr><th scope='row'>Upload Foto</th>              <td><input type='file' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Level</th>                   <td><input type='radio' name='g' value='inovator' checked> Pasien &nbsp; <input type='radio' name='g' value='user'> Dokter &nbsp; <input type='radio' name='g' value='admin'> Administrator &nbsp; <input type='radio' name='g' value='klinik'> Klinik
                    <tr><th scope='row'>Akses Modul</th>                    <td><div class='checkbox-scroll'>";
foreach ($record as $row) {
  echo "<span style='display:block'><input name='modul[]' type='checkbox' value='$row[id_modul]' /> $row[nama_modul]</span> ";
}
echo "</div></td></tr>
                  </tbody>
                  </table></div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='index.php'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
echo form_close();
