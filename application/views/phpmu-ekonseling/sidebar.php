<div class="profile-card">
  <div class="profile-top">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <img src="<?= $usr['foto'] ? base_url() . 'asset/foto_user/' . $usr['foto'] :  base_url() . 'asset/foto_user/blank.png' ?>" alt="Profile">
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="row">
          <div class="col-xs-12">
            <span class="text-primary"><b>Klien</b></span>
          </div>
          <div class="col-xs-12 mt-5">
            <b class="text-primary" style="font-size: 14px;"><?= $usr['nama_lengkap'] ?></b>
            <p style="font-size: 14px; word-wrap: anywhere"><?= $usr['email'] ?></p>
            <button class="btn btn-block btn-primary col-xs-12 col-md-6" style="font-size: 10px;" onclick="window.location.href='<?= base_url() . 'user/profile' ?>'">PROFIL SAYA</button>
            <button class="btn btn-block btn-primary col-xs-12 col-md-6" style="font-size: 10px;" onclick="window.location.href='<?= base_url() . 'user/konsultasi' ?>'">DATA KONSULTASI</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="profile-bottom">
    <button class="btn btn-block btn-warning" style="font-size: 10px;" onclick="window.location.href='<?= base_url() . 'user/tambah-konsultasi' ?>'"><i class="fab fa-wechat"></i> KONSULTASI SEKARANG</button>
  </div>
</div>