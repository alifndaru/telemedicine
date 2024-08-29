<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Code Voucher</h3>
            <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url(); ?>administrator/tambah_voucher'>Tambahkan Data voucher</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:10px'>No</th>
                        <th style='width:150px'>Code</th>
                        <th>Start</th>
                        <th>Expaired</th>
                        <th>Aktif</th>
                        <th>Nilai (%)</th>
                        <th style='width:50px'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($voucher as $row) {
                        echo "<tr><td>$no</td>
                              <td>$row[kode_voucher]</td>
                              <td>$row[start_date]</td>
                              <td>$row[end_date]</td>
							  <td>$row[aktif]</td>
                                <td>$row[nilai]</td>

                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='" . base_url() . "administrator/edit_voucher/$row[voucher_id]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='" . base_url() . "administrator/delete_voucher/$row[voucher_id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                          </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>