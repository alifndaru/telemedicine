<div class="container">
    <nav id="main-nav" class="main-nav navbar-inverse" role="navigation">
        <div class="navbar-custom1">
            <?php
            function top_menu()
            {
                $ci = &get_instance();
                $query = $ci->db->query("SELECT id_menu, nama_menu, link, id_parent FROM menu where aktif='Ya' AND position='Top' order by urutan");
                $menu = array('items' => array(), 'parents' => array());
                foreach ($query->result() as $menus) {
                    $menu['items'][$menus->id_menu] = $menus;
                    $menu['parents'][$menus->id_parent][] = $menus->id_menu;
                }
                if ($menu) {
                    $result = build_top_menu(0, $menu);
                    return $result;
                } else {
                    return FALSE;
                }
            }

            function build_top_menu($parent, $menu)
            {
                $html = "";
                if (isset($menu['parents'][$parent])) {
                    if ($parent == '0') {
                        $html .= "<ul class='nav navbar-nav'>";
                    } else {
                        $html .= "<ul class='dropdown-menu'>";
                    }
                    foreach ($menu['parents'][$parent] as $itemId) {
                        if (!isset($menu['parents'][$itemId])) {
                            if (preg_match("/^http/", $menu['items'][$itemId]->link)) {
                                $html .= "<li><a class='topm' target='_BLANK' href='" . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . "</a></li>";
                            } else {
                                $html .= "<li><a class='topm' href='" . base_url() . '' . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . "</a></li>";
                            }
                        }
                        if (isset($menu['parents'][$itemId])) {
                            if (preg_match("/^http/", $menu['items'][$itemId]->link)) {
                                $html .= "<li><a class='dropdown-toggle nav-item' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' target='_BLANK' href='" . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . " <span class='caret'></span></a>";
                            } else {
                                $html .= "<li><a class='dropdown-toggle nav-item' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' href='" . base_url() . '' . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . " <span class='caret'></span></a>";
                            }
                            $html .= build_top_menu($itemId, $menu);
                            $html .= "</li>";
                        }
                    }
                    $html .= "</ul>";
                }
                return $html;
            }
            echo top_menu();
            ?>


            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->session->level == 'inovator') { ?>
                    <li class="hiuser">
                        <img src="<?= !empty($this->session->foto) ? base_url('asset/foto_user/') . '/' . $this->session->foto : base_url('asset/foto_user/').'blank.png' ?>" class="img-thumbnail img-circle" alt="profile">
                        <a class='topm' href='<?php echo base_url(); ?>user/profile'>Hi <?php $y = explode(" ", $this->session->nama_lengkap);
                                                                                        echo ucwords(strtolower($y[0])); ?></a>
                    </li>
                    <li><a class='topm' href='<?php echo base_url(); ?>user/profile'>HALAMAN UTAMA</a></li>
                    <li><a class='topm' href='<?php echo base_url(); ?>user/logout'>KELUAR</a></li>
                <?php } else { ?>
                    <li><a href='<?php echo base_url(); ?>user/login' class='topm'><strong>Login</strong></a></li>
                    <li class="divider">|</li>
                    <li><a href='<?php echo base_url(); ?>user/pendaftaran' class='topm'><strong>Daftar Baru</strong></a></li>
                <?php } ?>
            </ul>
        </div><!--//navabr-collapse-->

    </nav><!--//main-nav-->
</div>