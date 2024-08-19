<div class="consultation-history-section">
  <?php
  // Fetch user data
  $usr = $this->db->query("SELECT * FROM users WHERE username='" . $this->session->username . "'")->row_array();
  ?>
  <div class="content-wrapper-history">

    <div class="left-section">
      <h2>KONSULTASI & HISTORI</h2>
      <div class="table-responsive">
        <table class="consultation-history-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Konsultasi</th>
              <th>Status</th>
              <th>Komentar</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch consultation records
            $no = 1;
            $records = $this->db->query("SELECT a.* FROM konsul a WHERE a.username='" . $this->session->username . "' ORDER BY a.id_konsul DESC");
            foreach ($records->result_array() as $row) {
              $komentar = $this->db->query("SELECT * FROM komentar_konsul WHERE id_konsul='$row[id_konsul]' AND aktif='Y'")->num_rows();
              $status = ($row['status'] == 'Y') ? '<span class="status in-progress">BERLANGSUNG</span>' : '<span class="status finished">SELESAI</span>';
              echo "<tr>
                    <td>$no</td>
                    <td><a target='_BLANK' href='" . base_url() . "konsultasi/detail/$row[id_konsul]'><b>$row[judul]</b></a></td>
                    <td>$status</td>
                    <td>$komentar Komentar</td>
                    <td><button class='edit-btn' onclick=\"window.location.href='" . base_url() . "konsultasi/history/$row[id_konsul]'\">Edit</button></td>
                  </tr>";
              $no++;
            }
            ?>
          </tbody>
        </table>
      </div>

      <div class="pagination">
        <?php
        // Example pagination logic
        $total_pages = ceil($records->num_rows() / 10); // assuming 10 records per page
        for ($i = 1; $i <= $total_pages; $i++) {
          echo "<span>$i</span> ";
        }
        ?>
      </div>
    </div>

    <!-- <div class="right-section">
      <div class="profile-card">
        <?php
        $foto_user = (trim($usr['foto']) == '') ? 'users.gif' : $usr['foto'];
        ?>
        <img src="<?= base_url() . 'asset/foto_user/' . $foto_user ?>" alt="Profile Image">
        <h3><?= $usr['nama_lengkap'] ?></h3>
        <p class="email"><?= $usr['email'] ?></p>
        <button class="profile-user-btn" onclick="window.location.href='<?= base_url() . 'user/profile' ?>'">PROFIL SAYA</button>
        <button class="consultation-data-btn" onclick="window.location.href='<?= base_url() . 'user/konsultasi' ?>'">DATA KONSULTASI</button>
        <button class="start-consultation-btn" onclick="window.location.href='<?= base_url() . 'user/tambah-konsultasi' ?>'">KONSULTASI SEKARANG</button>
      </div>
    </div> -->
    <div class="right-section">
      <div class="profile-card">
        <div class="profile-top">
          <img src="<?= base_url() . 'asset/foto_user/' . $foto_user ?>" alt="Profile Image">
          <div class="profile-info">
            <h3><?= $usr['nama_lengkap'] ?></h3>
            <p class="email"><?= $usr['email'] ?></p>
            <button class="profile-user-btn" onclick="window.location.href='<?= base_url() . 'user/profile' ?>'">PROFIL SAYA</button>
          </div>
        </div>
        <div class="profile-bottom">
          <button class="consultation-data-btn" onclick="window.location.href='<?= base_url() . 'user/konsultasi' ?>'">DATA KONSULTASI</button>
          <button class=" start-consultation-btn" onclick="window.location.href='<?= base_url() . 'user/tambah-konsultasi' ?>'">KONSULTASI SEKARANG</button>
        </div>
      </div>
    </div>
  </div>
</div>