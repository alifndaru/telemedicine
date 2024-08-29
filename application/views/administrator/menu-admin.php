        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <?php $usr = $this->model_app->view_where('users', array('username' => $this->session->username))->row_array();
              if (trim($usr['foto']) == '') {
                $foto = 'blank.png';
              } else {
                $foto = $usr['foto'];
              } ?>
              <img src="<?php echo base_url(); ?>/asset/foto_user/<?php echo $foto; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <?php echo "<p>$usr[nama_lengkap]</p>"; ?>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU <span class='uppercase'><?php echo $this->session->level; ?></span></li>
            <li><a href="<?php echo base_url(); ?>administrator/home"><i class="fa fa-dashboard"></i> <span>Halaman Utama</span></a></li>
            <li class="treeview">
              <a href="#"><i class="glyphicon glyphicon-th-list"></i> <span>Modul Utama</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php
                $cek = $this->model_app->umenu_akses("identitaswebsite", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/identitaswebsite'><i class='fa fa-circle-o'></i> Identitas Website</a></li>";
                }

                $cek = $this->model_app->umenu_akses("menuwebsite", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/menuwebsite'><i class='fa fa-circle-o'></i> Menu Utama</a></li>";
                }




                $cek = $this->model_app->umenu_akses("kategoridownload", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/download'><i class='fa fa-circle-o'></i> Menu Unggah Data</a></li>";
                }



                $cek = $this->model_app->umenu_akses("manajemenuser", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/manajemenuser'><i class='fa fa-circle-o'></i> Manajemen Pengguna</a></li>";
                }

                $cek = $this->model_app->umenu_akses("manajemenmodul", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/manajemenmodul'><i class='fa fa-circle-o'></i> Manajemen Modul</a></li>";
                }

                $cek = $this->model_app->umenu_akses("pesanmasuk", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/pesanmasuk'><i class='fa fa-circle-o'></i> Manajemen Saran</a></li>";
                }







                ?>

              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="glyphicon glyphicon-pencil"></i> <span>Modul Berita</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php
                $cek = $this->model_app->umenu_akses("listberita", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/listberita'><i class='fa fa-circle-o'></i> Berita</a></li>";
                }

                $cek = $this->model_app->umenu_akses("komentarberita", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/komentarberita'><i class='fa fa-circle-o'></i> Komentar</a></li>";
                }

                $cek = $this->model_app->umenu_akses("kategoriberita", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/kategoriberita'><i class='fa fa-circle-o'></i> Kategori</a></li>";
                }
                ?>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-users" aria-hidden="true"></i><span>Modul IPES</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php
                $cek = $this->model_app->umenu_akses("kategorilayanan", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/kategori_layanan'><i class='fa fa-circle-o'></i> Kategori IPES</a></li>";
                }
                ?>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Modul Voucher</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php
                $cek = $this->model_app->umenu_akses("voucher", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/voucher'><i class='fa fa-circle-o'></i> Manajemen Voucher</a></li>";
                }
                ?>
              </ul>
            </li>

            <?php if ($this->session->level == 'admin' or $this->session->level == 'klinik') { ?>
              <li class="treeview">
                <a href="#"><i class="glyphicon glyphicon-grain" aria-hidden="true"></i><span>Modul Daerah</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php
                  $cek = $this->model_app->umenu_akses("klinik", $this->session->id_session);
                  if ($cek == 1 or $this->session->level == 'admin' or $this->session->level == 'klinik') {
                    echo "<li><a href='" . base_url() . "administrator/klinik'><i class='fa fa-circle-o'></i> Manajemen Daerah</a></li>";
                  }
                  $cek = $this->model_app->umenu_akses("laporankonsul", $this->session->id_session);
                  if ($cek == 1 or $this->session->level == 'admin' or $this->session->level == 'klinik') {
                    echo "<li><a href='" . base_url() . "administrator/laporan-konsultasi'><i class='fa fa-circle-o'></i> Laporan Daerah</a></li>";
                  }
                  ?>
                </ul>
              </li>
            <?php } ?>

            <li class="treeview">
              <a href="#"><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> <span>Modul Konsultasi</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php
                $cek = $this->model_app->umenu_akses("konsul", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/konsul'><i class='fa fa-circle-o'></i> Konsultasi</a></li>";
                }

                $cek = $this->model_app->umenu_akses("komentar_konsul", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/komentar_konsul'><i class='fa fa-circle-o'></i> Komentar Konsul</a></li>";
                }


                ?>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="glyphicon glyphicon-object-align-left"></i> <span>Modul Web</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php
                $cek = $this->model_app->umenu_akses("logowebsite", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/logowebsite'><i class='fa fa-circle-o'></i> Logo Website</a></li>";
                }

                $cek = $this->model_app->umenu_akses("iklansidebar", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/iklansidebar'><i class='fa fa-circle-o'></i> Banner Sidebar</a></li>";
                }

                $cek = $this->model_app->umenu_akses("slider", $this->session->id_session);
                if ($cek == 1 or $this->session->level == 'admin') {
                  echo "<li><a href='" . base_url() . "administrator/slider'><i class='fa fa-circle-o'></i> Banner Slider</a></li>";
                }
                ?>
                <ul class="treeview-menu">
                </ul>
              </ul>
            </li>

            <li><a href="<?php echo base_url(); ?>administrator/edit_manajemenuser/<?php echo $this->session->username; ?>"><i class="fa fa-edit"></i> <span>Edit Profile</span></a></li>
            <li><a href="<?php echo base_url(); ?>administrator/logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
          </ul>
        </section>