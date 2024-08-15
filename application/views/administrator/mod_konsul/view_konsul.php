            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Semua Konsultasi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="2" style='width:1px'>No</th>
                        <th width="200">Judul Topic</th>
                        <th width="100">Nama Klien</th>
                        <th width="100">Status</th>
                        <th width="100">Jumlah Isi</th>
                        <th width="1" style='width:100px'>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    $records = $this->db->query("SELECT a.*, c.nama_lengkap FROM konsul a JOIN users c ON a.username=c.username ORDER BY a.id_konsul DESC");
                    foreach ($records->result_array() as $row){
                    $komentar = $this->db->query("SELECT * FROM komentar_konsul where id_konsul='$row[id_konsul]' AND aktif='Y'")->num_rows();
                    if ($row['status']=='Y'){ $status = '<span style="color:blue">Konsultasi Berlangsung</span> <br><small><i>Sudah Terbit</i></small>'; }else{ $status = '<span style="color:red">Konsultasi Selesai</span> '; }
                    $tgl_posting = tgl_indo($row['tanggal']);
                    echo "<tr><td>$no</td>
                              <td><small>$row[hari], $tgl_posting, $row[jam] WIB</small> <br><a target='_BLANK' href='".base_url()."konsultasi/detail/$row[id_konsul]'><b>$row[judul]</b></a></td>
                              <td>$row[nama_lengkap]</td>
                              <td>$status</td>
                              <td>$komentar Komentar</td>
                              <td><center>
                                <a class='btn btn-primary btn-xs' title='Edit Data' href='".base_url()."administrator/publish_konsul/$row[id_konsul]/$row[status]'><span class='glyphicon glyphicon-ok'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url()."user/delete_konsul/$row[id_konsul]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                <a class='btn btn-success btn-xs' download href='".base_url()."konsultasi/history/$row[id_konsul]'><span class='glyphicon glyphicon-file'></span></a>
                              </center></td>
                          </tr>";
                      $no++;
                    }
                  ?>
                  </tbody>
                </table>
              </div>