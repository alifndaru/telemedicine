<div class="wrapper container">
	<nav id="main-nav" class="main-nav navbar-inverse" role="navigation">
		<div class="navbar-header">
			<?php
			$logo = $this->model_utama->view_ordering_limit('logo', 'id_logo', 'DESC', 0, 1);
			foreach ($logo->result_array() as $row) {
				echo "<a class='navbar-brand' style='padding:24px 15px 15px 0px' href='" . base_url() . "'><img class='logo' style='height:45px; margin-top:-20px;' src='" . base_url() . "asset/logo/$row[gambar]'/></a>";
			}
			?>

		</div><!--//navbar-header-->
		<div class="navbar-collapse collapse navbar-custom1" id="navbar-collapse">
			<?php
			function main_menu()
			{
				$ci = &get_instance();
				$query = $ci->db->query("SELECT id_menu, nama_menu, link, id_parent FROM menu where aktif='Ya' AND position='Bottom' order by urutan");
				$menu = array('items' => array(), 'parents' => array());
				foreach ($query->result() as $menus) {
					$menu['items'][$menus->id_menu] = $menus;
					$menu['parents'][$menus->id_parent][] = $menus->id_menu;
				}
				if ($menu) {
					$result = build_main_menu(0, $menu);
					return $result;
				} else {
					return FALSE;
				}
			}

			function build_main_menu($parent, $menu)
			{
				$html = "";
				if (isset($menu['parents'][$parent])) {
					if ($parent == '0') {
						$html .= "<ul class='nav navbar-nav navbar-right'>";
					} else {
						$html .= "<ul class='dropdown-menu'>";
					}

					foreach ($menu['parents'][$parent] as $itemId) {
						if (!isset($menu['parents'][$itemId])) {
							if (preg_match("/^http/", $menu['items'][$itemId]->link)) {
								$html .= "<li class='dropdown'><a target='_BLANK' href='" . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . "</a></li>";
							} else {
								if (strtolower($menu['items'][$itemId]->nama_menu) == 'hubungi kami') {
									$html .= "<li class='dropdown contact-menu'><a href='" . base_url() . '' . $menu['items'][$itemId]->link . "'><i class='fa fa-map-marker' aria-hidden='true'></i></a></li>";
								} else {
									$html .= "<li class='dropdown'><a href='" . base_url() . '' . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . "</a></li>";
								}
							}
						}
						if (isset($menu['parents'][$itemId])) {
							if (preg_match("/^http/", $menu['items'][$itemId]->link)) {
								$html .= "<li class='dropdown-submenu'><a class='dropdown-toggle nav-item' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' target='_BLANK' href='" . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . "</a>";
							} else {
								$html .= "<li class='dropdown-submenu'><a tabindex='-1' class='dropdown-toggle nav-item' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' href='" . base_url() . '' . $menu['items'][$itemId]->link . "'>" . $menu['items'][$itemId]->nama_menu . "</a>";
							}

							$html .= build_main_menu($itemId, $menu);
							$html .= "</li>";
						}
					}
					// $html .= "<li class='dropdown'><a><i class='fa fa-map-marker' aria-hidden='true'></i></a></li>";
					$html .= "</ul>";
				}
				return $html;
			}
			echo main_menu();
			?>
		</div><!--//navabr-collapse-->

	</nav><!--//main-nav-->

</div>