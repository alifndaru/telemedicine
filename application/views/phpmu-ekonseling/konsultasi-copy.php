<?php
$usr = $this->db->query("SELECT * FROM users where username='" . $this->session->username . "'")->row_array();
?>


<div class="row container">
  <div class="col-md-8 col-sm-12 clearfix">
    <div class="breadcrumb">
      <a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?>
    </div>
    <?php if ($usr['blokir'] == 'Y') {
      echo "<h2>$title  <a href='#' data-toggle='modal' data-target='#myModall' class='btn btn-sm btn-primary pull-right'>Tambahkan Data</a> </h2><br>";
    } else {
    }
    echo $this->session->flashdata('message'); ?>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style='width:20px'>No</th>
          <th>Judul Konsultasi</th>
          <th>Status</th>
          <th>Komentar</th>
          <th style='width:40px'>Catatan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        header("refresh: 30; url = " . base_url('user/konsultasi'));
        $no = 1;
        $records = $this->db->query("SELECT a.* FROM konsul a  WHERE a.username='" . $this->session->username . "' ORDER BY a.id_konsul DESC");
        foreach ($records->result_array() as $row) {
          $komentar = $this->db->query("SELECT * FROM komentar_konsul where id_konsul='$row[id_konsul]' AND aktif='Y'")->num_rows();
          if ($row['status'] == 'Y') {
            $status = '<b><span style="color:#3333FF">Berlangsung</span></b> <br><small><i></i></small>';
          } else {
            $status = '<b><span style="color:#FF0000">Selesai</span></b> <br><small><i></i></small>';
          }
          $tgl_posting = tgl_indo($row['tanggal']);
          echo "<tr><td>$no</td>
                      <td><small>$row[hari], $tgl_posting, $row[jam] WIB</small> <br><a target='_BLANK' href='" . base_url() . "konsultasi/detail/$row[id_konsul]'><b>$row[judul]</b></a></td>
                      <b><td>$status</td><</b>
                      <td>$komentar Komentar</td>
                      <td><center>
                        <a download class='btn btn-success btn-xs' title='Laporan konsultasi' href='" . base_url() . "konsultasi/history/$row[id_konsul]'><span class='glyphicon glyphicon-file'></span></a>
                      </center></td>
                  </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>




  <div class="col-md-4 sidebar col-sm-12">
    <?php include "sidebar.php"; ?>
  </div>
</div>

<div class="modal fade" id="myModall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style='font-size:16px' class="modal-title" id="myModalLabel">Akun Belum Aktif</h4>
      </div>
      <div class="modal-body">
        <center>Maaf, saat ini akun anda belum aktif, silahkan untuk menunggu paling lambat 1x24 jam agar di verifikasi oleh admin agar bisa melakukan konsultasi, Terima kasih,.. </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>