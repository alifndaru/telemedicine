            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Komentar Konsultasi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th width='140px'>Nama Pengguna</th>
                        <th>Isi Komentar</th>
                        <th>Aktif</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $row){
                    $brt = $this->model_app->view_where('konsul',array('id_konsul'=>$row['id_konsul']))->row_array();
                    if ($row['aktif']=='N'){ $bold = 'bold'; $color = 'red'; }else{ $bold = 'none'; $color = ''; }
                    $isi_komentar =(strip_tags($row['isi_komentar'])); 
                    $isi = substr($isi_komentar,0,110); 
                    $isi = substr($isi_komentar,0,strrpos($isi," ")); 
                    echo "<tr style='font-weight:$bold; color:$color'><td>$no</td>
                              <td><a target='_BLANK' href='".base_url()."konsultasi/detail/$brt[id_konsul]'>$row[nama_komentar]</a></td>
                              <td>$isi... <br><small><a target='_BLANK' href='".base_url()."konsultasi/detail/$brt[id_konsul]'>".base_url()."konsultasi/detail/$brt[id_konsul]</a></small></td>
                              <td>$row[aktif]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url()."administrator/publish_komentar_konsul/$row[id_komentar]/$row[aktif]'><span class='glyphicon glyphicon-ok'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url()."administrator/delete_komentar_konsul/$row[id_komentar]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                          </tr>";
                      $no++;
                    }
                  ?>
                  </tbody>
                </table>
              </div>