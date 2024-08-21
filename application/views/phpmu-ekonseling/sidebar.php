<div class="profile-card">
  <div class="profile-top">
    <img src="<?= base_url() . 'asset/foto_user/' . $usr['foto'] ?>" alt="Profile Image">
    <div class="profile-info">
      <h3><?= $usr['nama_lengkap'] ?></h3>
      <p class="email"><?= $usr['email'] ?></p>
      <button class="profile-user-btn" onclick="window.location.href='<?= base_url() . 'user/profile' ?>'">PROFIL SAYA</button>
    </div>
  </div>
  <div class="profile-bottom">
    <button class="consultation-data-btn" onclick="window.location.href='<?= base_url() . 'user/konsultasi' ?>'">DATA KONSULTASI</button>
    <button class="start-consultation-btn" onclick="window.location.href='<?= base_url() . 'user/tambah-konsultasi' ?>'">TAMBAH KONSULTASI</button>
  </div>
</div>