            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manajemen Pengguna</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url(); ?>administrator/tambah_manajemenuser'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th style='width:70px'>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $row){
                    if ($row['foto'] == ''){ $foto ='blank.png'; }else{ $foto = $row['foto']; }
                    if ($row['blokir'] == 'Y'){ $aktif ='<i style="color:red">Non Aktif</i>'; }else{ $aktif ='<i style="color:green">Aktif</i>'; }
                    if ($row['level'] == 'inovator'){ $level ='<span style="color:magenta">Klien</span>'; }elseif ($row['level'] == 'user'){ $level ='<span style="color:blue">Provider</span>'; }elseif ($row['level'] == 'klinik') {$level ='<span style="color:black">Klinik</span>';} else{ $level ='<span style="color:red">Admin</span>'; }
                    echo "<tr><td>$no</td>
                              <td>$row[username]</td>
                              <td>$row[nama_lengkap]</td>
                              <td>$row[email]</td>
                              <td>$aktif</td>
                              <td>$level</td>";
                              if ($row['level']=='admin'){
                                echo "<td><center>
                                  <a class='btn btn-success btn-xs' style='width:52px' title='Edit Data' href='".base_url()."administrator/edit_manajemenuser/$row[username]'><span class='glyphicon glyphicon-edit'></span></a>
                                </center></td>";
                              }else{
                                echo "<td><center>
                                  <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url()."administrator/edit_manajemenuser/$row[username]'><span class='glyphicon glyphicon-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url()."administrator/delete_manajemenuser/$row[username]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                </center></td>";
                              }
                          echo "</tr>";
                      $no++;
                    }
                  ?>
                  </tbody>
                </table>
              </div>