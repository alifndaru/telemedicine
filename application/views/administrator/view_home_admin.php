  <a style='color:#000' href='<?php echo base_url(); ?>administrator/slider'>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-file"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Slider Gambar</span>
        <?php $jmlb = $this->model_app->view('slider')->num_rows(); ?>
        <span class="info-box-number"><?php echo $jmlb; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  </a>

  <a style='color:#000' href='<?php echo base_url(); ?>administrator/konsul'>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Konsultasi</span>
        <?php $jmla = $this->model_app->view('konsul')->num_rows(); ?>
        <span class="info-box-number"><?php echo $jmla; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  </a>

  <a style='color:#000' href='<?php echo base_url(); ?>administrator/komentar_konsul'>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Komentar</span>
        <?php $jmlc = $this->model_app->view('komentar_konsul')->num_rows(); ?>
        <span class="info-box-number"><?php echo $jmlc; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  </a>

  <a style='color:#000' href='<?php echo base_url(); ?>administrator/manajemenuser'>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Users</span>
        <?php $jmld = $this->model_app->view('users')->num_rows(); ?>
        <span class="info-box-number"><?php echo $jmld; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  </a>

<section class="col-lg-7 connectedSortable">
  <?php 
    $jmlpesan = $this->model_app->view_where('hubungi', array('dibaca'=>'N'))->num_rows(); 
    $jmlberita = $this->model_app->view_where('komentar', array('aktif'=>'N'))->num_rows(); 
  ?>
  <div class='box' style='min-height:100px;'>
  <div class='box' style='min-width:1070px;'>
    <div class='box-header'>
      <h3 class='box-title'>Tombol Aplikasi</h3>
    </div>
    <div class='box-body'>
      <p>Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola konten website anda 
          atau pilih ikon-ikon pada Control Panel di bawah ini : </p>
      
      <a href="<?php echo base_url(); ?>administrator/menuwebsite" class='btn btn-app'><i class='fa fa-th-large'></i> Menu</a>

      <a href="<?php echo base_url(); ?>administrator/listberita" class='btn btn-app'><i class='fa fa-television'></i> Berita</a>
     
      
      <a href="<?php echo base_url(); ?>administrator/konsul" class='btn btn-app'><i class='fa fa-television'></i> Konsultasi</a>
      <a href="<?php echo base_url(); ?>administrator/kategori_konsul" class='btn btn-app'><i class='fa fa-bars'></i> Kategori</a>
      <a href="<?php echo base_url(); ?>administrator/komentar_konsul" class='btn btn-app'><i class='fa fa-comment'></i> Komentar</a>
    
      <a href="<?php echo base_url(); ?>administrator/iklansidebar" class='btn btn-app'><i class='fa fa-file-image-o'></i> Ads Sidebar</a>
      <a href="<?php echo base_url(); ?>administrator/logowebsite" class='btn btn-app'><i class='fa fa-circle-thin'></i> Logo</a>

      <a href="<?php echo base_url(); ?>administrator/download" class='btn btn-app'><i class='fa fa-download'></i> Dokumen</a>
     
      <a href="<?php echo base_url(); ?>administrator/pesanmasuk" class='btn btn-app'><span class='badge bg-yellow'><?php echo $jmlpesan; ?></span><i class='fa fa-envelope'></i> Pesan</a>
      <a href="<?php echo base_url(); ?>administrator/manajemenuser" class='btn btn-app'><i class='fa fa-users'></i> Users</a>
    </div>
  </div>
</section>


<p>
  <!-- /.Left col -->
  
  <section class="col-lg-5 connectedSortable">  </section>
  <!-- right col -->
</p>

