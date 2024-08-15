<?php

    echo "<div class='col-md-5'>
          <div class='box'>
            <div class='box-header'>
              <h3 class='box-title'>Selamat Datang di Halaman Utama</h3>
            </div>
			
			
            <div class='box-body'>
              <p>Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola Tulisan anda pada web ini, berikut informasi akun anda saat ini : </p>
              <dl class='dl-horizontal'>
                <dt>ID Anda</dt>
                <dd>$users[user_id]</dd>

                <dt>Username</dt>
                <dd>$users[username]</dd>

                <dt>Password</dt>
                <dd>***********</dd>

                <dt>Nama Lengkap</dt>
                <dd>$users[nama_lengkap]</dd>

                <dt>Alamat Email</dt>
                <dd>$users[email]</dd>

                <dt>No. Telpon</dt>
                <dd>$users[no_telp]</dd>

                
              <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h4><i class='icon fa fa-info'></i> Info Penting!</h4>
                Diharapkan informasi akun sesuai dengan identitas pada Kartu Pengenal anda, Untuk Mengubah informasi Profile anda klik <a href='".base_url()."administrator/edit_manajemenuser/".$this->session->username."'>disini</a>.
              </div>
            </div>
          </div>
        </div>

        <section class='col-lg-7 connectedSortable'>
            <div class='box box-success'>
            <div class='box-header'>
            <i class='fa fa-th-list'></i>
            <h3 class='box-title'>Semua Konsultasi Masuk</h3>
                <div class='box-tools pull-right'>
                   <button class='btn btn-box-tool' data-widget='collapse' data-toggle='tooltip' title='Collapse'><i class='fa fa-minus'></i></button>
                    <button class='btn btn-box-tool' data-widget='remove' data-toggle='tooltip' title='Remove'><i class='fa fa-times'></i></button>
                </div>
                </div>
				
				

        <div class='box-body chat' id='chat-box'>
        <table id='example1' class='table table-bordered table-striped table-condensed'>
            <thead>
              <tr>
                <th style='width:20px'>No</th>
                <th>Keluhan</th>
                <th>Waktu</th>
                <th>Isi Pesan </th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>";
            $records = $this->db->query("SELECT a.* FROM konsul a ORDER BY a.id_konsul DESC;");
            if ($this->session->level == 'klinik') {
              $uid = $this->session->user_id;
              $user = $this->db->query("SELECT a.klinik_id FROM users a WHERE a.user_id = '$uid'")->result_array();
              $kid = $user[0]['klinik_id'];
              $records = $this->db->query("SELECT a.* FROM konsul a WHERE a.klinik_id = '$kid' ORDER BY a.id_konsul DESC");
            }

            if ($this->session->level == 'user') {
              $uid = $this->session->user_id;
              $records = $this->db->query("SELECT a.* FROM konsul a WHERE a.dokter = '$uid' ORDER BY a.id_konsul DESC");
            }
            
            $no = 1;
            
            foreach ($records->result_array() as $row){
            $komentar = $this->db->query("SELECT * FROM komentar_konsul where id_konsul='$row[id_konsul]' AND aktif='Y'")->num_rows();
            if ($row['status']=='Y'){ $status = '<b><span style="color:#3333FF">Berlangsung</span></b>'; }else{ $status = '<b><span style="color:#FF0000">Selesai</span></b>'; }
            $cek_terakhir = cek_terakhir($row['tanggal'].' '.$row['jam']);
            echo "<tr><td>$no</td>
                      <td><a target='_BLANK' href='".base_url()."konsultasi/detail/$row[id_konsul]'><b>$row[judul]</b></a></td>
                      <td><span style=color:#009933>$cek_terakhir lalu</td></span>
                      <td>$komentar Komentar</td>
					  <td>$status</td>
                      <td><center><a download href='".base_url()."konsultasi/history/$row[id_konsul]'><span class='glyphicon glyphicon-file'></span></a></center></td>
                  </tr>";
              $no++;
            }

          echo "</tbody>
        </table>
        </div>
        </div>
        </section>";