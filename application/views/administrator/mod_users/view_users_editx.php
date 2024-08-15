<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">

<style>
   /* vue-select */
   .vs__no-options {
      text-align: left !important;
      padding-left: 8px;
   }

   .vs__clear {
      margin-bottom: 1px;
   }
   .vs__dropdown-menu {
        height: 200px !important;
   }
</style>
<div id="edit-user" class="col-md-12">
   <div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title">Edit Data Pengguna</h3>
      </div>
      <div class="box-body">
         <form action="<?php echo base_url('/administrator/edit_manajemenuser'); ?>" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
         <?php if ($rows['foto'] == ''){ $foto = 'users.gif'; } else { $foto = $rows['foto'];} ?>
            <div class="col-md-12">
               <table class="table table-condensed table-bordered">
                  <tbody>
                     <input type="hidden" name="id" value="<?php echo $rows['username']; ?>">
                     <input type="hidden" name="ids" value="<?php echo $rows['id_session']; ?>">
                     <tr>
                        <th width="140px" scope="row">User ID</th>
                        <td><input type="text" ref="uid" class="form-control" name="a" value="<?php echo $rows['user_id']; ?>" readonly="on"></td>
                     </tr>
                     <tr>
                        <th width="140px" scope="row">Username</th>   
                        <td><input type="text" class="form-control" name="a" value="<?php echo $rows['username']; ?>" readonly="on"></td>
                     </tr>
                     <tr>
                        <th scope="row">Password</th>                 
                        <td><input type="password" class="form-control" name="b" onkeyup="nospaces(this)"></td>
                     </tr>
                     <tr>
                        <th scope="row">Nama Lengkap</th>             
                        <td><input type="text" class="form-control" name="c" value="<?php echo $rows['nama_lengkap']; ?>"></td>
                     </tr>
                     <tr>
                        <th scope="row">Alamat Email</th>                    
                        <td><input type="email" class="form-control" name="d" value="<?php echo $rows['email']; ?>"></td>
                     </tr>
                     <tr>
                        <th scope="row">No Telepon</th>                  
                        <td><input type="number" class="form-control" name="e" value="<?php echo $rows['no_telp']; ?>"></td>
                     </tr>
                     <tr>
                        <th scope="row">Alamat Lengkap</th>                  
                        <td><input type="text" class="form-control" name="alamat" value="<?php echo $rows['alamat_lengkap']; ?>"></td>
                     </tr>
                     <tr>
                        <th scope="row">Tempat Lahir</th>                  
                        <td><input type="text" class="form-control" name="tempat_lahir" value="<?php echo $rows['tempat_lahir']; ?>"></td>
                     </tr>
                     <tr>
                       <th scope="row">Tanggal Lahir</th>
                       <td><input type="text" class="form-control" name="tanggal_lahir" value="<?php echo $rows['tanggal_lahir']; ?>" /></td>
                     </tr>
                     <tr>
                       <th scope="row">No STR </th>
                       <td><input type="text" class="form-control" name="str" value="<?php echo $rows['str']; ?>" /></td>
                     </tr>
                     <tr>
                        <th scope="row">No SIP </th>                  
                        <td><input type="text" class="form-control" name="sip" value="<?php echo $rows['sip']; ?>"></td>
                     </tr>
					 					 
                     <tr>
                        <th scope="row">Jenis Kelamin</th>                  
                        <td>
                           <?php if ($rows['jenis_kelamin']=='Laki-laki') { ?>
                              <input type="radio" name="kelamin" value="Laki-laki" checked> Laki-laki
                              <input type="radio" name="kelamin" value="Perempuan"> Perempuan
                           <?php } else { ?>
                              <input type="radio" name="kelamin" value="Laki-laki"> Laki-laki
                              <input type="radio" name="kelamin" value="Perempuan" checked> Perempuan
                           <?php } ?>                        </td>
                     </tr>
                     <tr>
                        <th scope="row">Status Kawin</th>                  
                        <td>
                           <select class="form-control" name="status" required="">
                              <?php $status = array('Kawin','Belum Kawin','Duda / Janda'); ?>
                              <?php for ($i=0; $i < count($status); $i++) { 
                                 if ($rows['status_kawin']==$status[$i]) { ?>
                                   <option value="<?php echo $status[$i]; ?>" selected><?php echo $status[$i]; ?></option>;
                                 <?php } else { ?>
                                   <option value="<?php echo $status[$i]; ?>"><?php echo $status[$i]; ?></option>;
                              <?php }} ?>
                           </select>                        </td>
                     </tr>
                     <tr>
                        <th scope="row">Agama</th>                  
                        <td>
                           <select class="form-control" name="agama" required="">
                              <?php $agama = array('Islam','Kristen','Hindu','Buddha','Katolik','Khonghucu','Lainnya'); ?>
                              <?php for ($i=0; $i < count($agama); $i++) {
                                 if ($rows['agama']==$agama[$i]) { ?>
                                    <option value="<?php echo $agama[$i]; ?>" selected><?php echo $agama[$i]; ?></option>;
                                 <?php } else { ?>
                                    <option value="<?php echo $agama[$i]; ?>"><?php echo $agama[$i]; ?></option>;
                              <?php }} ?>
                           </select>                        </td>
                     </tr>
                     <tr>
                        <th scope="row">Jabatan</th>                  
                        <td><input type="text" class="form-control" name="perangkat_daerah" value="<?php echo $rows['perangkat_daerah']; ?>"></td>
                     </tr>
                     <tr>
                        <th scope="row">Ganti Foto</th>                     
                        <td>
                           <input type="file" class="form-control" name="f">
                           <hr style="margin:5px">
                           <?php if ($rows['foto'] != ''){ echo "<i style='color:red'>Foto Saat ini : </i><a target='_BLANK' href='".base_url()."asset/foto_user/$rows[foto]'>$rows[foto]</a>"; } ?>                        </td>
                     </tr>
                     <?php if ($this->session->level == 'admin') { ?>
                        <tr>
                           <th scope="row">Status</th>                   
                           <td>
                              <?php if ($rows['blokir']=='Y') { ?>
                                 <input type="radio" name="h" value="Y" checked> Non Aktif &nbsp; 
                                 <input type="radio" name="h" value="N"> Aktif
                              <?php } else { ?>
                                 <input type="radio" name="h" value="Y"> Non Aktif &nbsp; 
                                 <input type="radio" name="h" value="N" checked> Aktif
                              <?php } ?>                           </td>
                        </tr>
                        <?php if ($rows['level'] == 'klinik') { ?>
                           <tr>
                              <th scope="row">Klinik</th>
                              <td>
                                 <div class="form-group">
                                    <div class="col-sm-12 mb-10">
                                        <v-select 
                                            :disabled="disops.klinik === true" 
                                            label="klinik" 
                                            v-model="klinik" 
                                            :reduce="klinik => klinik.id" 
                                            :options="klinik_options"
                                            @search="fetchOptionsKlinik" 
                                            @search:focus="fetchOptionsKlinik"
                                            @input="selectedOptionKlinik">                                        </v-select>
                                    </div>
                                </div>                              </td>
                           </tr>
                        <?php } ?>
                     <?php } ?> 
                     <?php if ($rows['level'] == 'admin') { ?>
                        <tr><th scope='row'>Tambah Akses</th>
                        <td>
                           <div class='checkbox-scroll'>
                              <?php foreach ($record as $row) { ?>
                              <span style='display:block'>
                                 <input name='modul[]' type='checkbox' value="<?php echo $row['id_modul']; ?>" /> <?php echo $row['nama_modul']; ?>                              </span>
                              <?php } ?>
                           </div>                        </td>
                     </tr>
                     <tr>
                        <th scope='row'>Hak Akses</th>       
                        <td>
                           <div class='checkbox-scroll'>
                           <?php foreach ($akses as $ro) { ?>
                              <span style="display:block"><a class="text-danger" href="<?php echo base_url('administrator/delete_akses/').'/'.$ro['id_umod'].'/'.$this->uri->segment(3); ?>"><span class='glyphicon glyphicon-remove'></span></a> <?php echo $ro['nama_modul']; ?></span>
                           <?php } ?>
                           </div>                        </td>
                     </tr>;
                     <?php } ?>
                  </tbody>
               </table>
            </div>
              
            <div class="box-footer">
               <input type="hidden" v-model="klinik" name="klinik">
               <button type="submit" name="submit" class="btn btn-info">Perbaharui</button>
               <a href="home"><button type="button" class="btn btn-default pull-right">Batal</button></a>
                    
            </div>
         </form>
      </div>
   </div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/edit-user.js'); ?>"></script>