<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
	public function index()
	{
		redirect('user/login');
	}

	public function login()
	{
		if (isset($_POST['submit'])) {
			$username = $this->input->post('a');
			$password = hash("sha512", md5($this->input->post('b')));
			$cek = $this->model_app->cek_login_users($username, $password, 'users');
			$row = $cek->row_array();
			$total = $cek->num_rows();
			if ($total > 0) {
				$this->session->set_userdata('upload_image_file_manager', true);
				$this->session->set_userdata(array(
					'username' => $row['username'],
					'nama_lengkap' => $row['nama_lengkap'],
					'foto' => $row['foto'],
					'level' => $row['level'],
					'user_id' => $row['user_id'],
					'id_session' => $row['id_session']
				));
				redirect('user/konsultasi');
			} else {
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Maaf, Username dan Password Salah!!</center></div>');
				redirect('user/login');
			}
		} else {
			$data['title'] = "Login members";
			$data['description'] = description();
			$data['keywords'] = keywords();
			$this->template->load(template() . '/template', template() . '/login', $data);
		}
	}

	function pendaftaran()
	{
		if (isset($_POST['submit'])) {
			if ($this->input->post()) {
				$cek = $this->db->query("SELECT * FROM users where username='" . cetak($this->input->post('a')) . "' OR email='" . cetak($this->input->post('d')) . "'");
				if ($cek->num_rows() >= 1) {
					echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center><b>GAGAL</b> - Maaf Username atau Email Sudah terdaftar di system!!</center></div>');
					redirect('user/pendaftaran');
				} elseif ($this->input->post('b') != $this->input->post('bb')) {
					echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center><b>GAGAL</b> - Maaf Password dan Confirm Password Harus sama!</center></div>');
					redirect('user/pendaftaran');
				} else {
					$config['upload_path'] = 'asset/foto_user/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$config['max_size'] = '1000000'; // kb
					$this->load->library('upload', $config);
					$this->upload->do_upload('f');
					$hasil = $this->upload->data();
					$nama_lengkap = $this->input->post('c') . ' ' . $this->input->post('cc');

					// generate user ID
					$last_id = $this->model_app->last_user_id()->row_array();
					$last_id_new = intval($last_id['id']) + 1;
					$user_id_s = substr_replace("0000", $last_id_new, -strlen($last_id_new));
					$user_id = "";
					// $klinik = null;

					// if ($this->input->post('g') == 'inovator') {
					// 	$user_id = "P-".$user_id_s;
					// } elseif ($this->input->post('g') == 'user') {
					// 	$user_id = "D-".$user_id_s;
					// } elseif ($this->input->post('g') == 'admin') {
					// 	$user_id = "A-".$user_id_s;
					// } elseif ($this->input->post('g') == 'klinik') {
					// 	$user_id = "K-".$user_id_s;
					// } else {
					// 	$user_id = "";
					// }
					$user_id = "P-" . $user_id_s;

					if ($hasil['file_name'] == '') {
						$data = array(
							'username' => cetak($this->input->post('a')),
							'password' => hash("sha512", md5(cetak($this->input->post('b')))),
							'nama_lengkap' => cetak($nama_lengkap),
							'email' => cetak($this->input->post('d')),
							'no_telp' => cetak($this->input->post('e')),
							'jenis_kelamin' => cetak($this->input->post('kelamin')),
							'alamat_lengkap' => cetak($this->input->post('alamat')),
							'tempat_lahir' => cetak($this->input->post('tempat_lahir')),
							'tanggal_lahir' => cetak($this->input->post('tanggal_lahir')),
							'status_kawin' => cetak($this->input->post('status')),
							'agama' => cetak($this->input->post('agama')),
							//  'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
							'perangkat_daerah' => "Klien",
							'level' => 'inovator',
							'blokir' => 'N',
							'user_id' => $user_id,
							'id_session' => md5(cetak($this->input->post('a'))) . '-' . date('YmdHis')
						);
					} else {
						$data = array(
							'username' => cetak($this->input->post('a')),
							'password' => hash("sha512", md5(cetak($this->input->post('b')))),
							'nama_lengkap' => cetak($nama_lengkap),
							'email' => cetak($this->input->post('d')),
							'no_telp' => cetak($this->input->post('e')),
							'jenis_kelamin' => cetak($this->input->post('kelamin')),
							'alamat_lengkap' => cetak($this->input->post('alamat')),
							'tempat_lahir' => cetak($this->input->post('tempat_lahir')),
							'tanggal_lahir' => cetak($this->input->post('tanggal_lahir')),
							'status_kawin' => cetak($this->input->post('status')),
							'agama' => cetak($this->input->post('agama')),
							//  'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
							'perangkat_daerah' => "Klien",
							'foto' => $hasil['file_name'],
							'level' => 'inovator',
							'blokir' => 'N',
							'user_id' => $user_id,
							'id_session' => md5(cetak($this->input->post('a'))) . '-' . date('YmdHis')
						);
					}

					$this->model_app->insert('users', $data);
					$datam = array(
						'id_session' => md5(cetak($this->input->post('a'))) . '-' . date('YmdHis'),
						'id_modul' => 18
					);
					$this->model_app->insert('users_modul', $datam);
					$this->session->set_userdata('upload_image_file_manager', true);
					$this->session->set_userdata(array(
						'username' => cetak($this->input->post('a')),
						'level' => 'inovator',
						'id_session' => md5(cetak($this->input->post('a'))) . '-' . date('YmdHis')
					));
					redirect('user/login');
				}
			} else {
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center><b>GAGAL</b> - Kode Keamanan yang anda masukkan salah!!!</center></div>');
				redirect('user/pendaftaran');
			}
		} else {
			$data['title'] = "Registrasi / Pendaftaran Users";
			$data['description'] = description();
			$data['keywords'] = keywords();

			$this->load->helper('captcha');
			$vals = array(
				'img_path'	 => './captcha/',
				'img_url'	 => base_url() . 'captcha/',
				'font_path' => './asset/Tahoma.ttf',
				'font_size'     => 14,
				'img_width'	 => '90',
				'img_height' => 32,
				'border' => 0,
				'word_length'   => 5,
				'expiration' => 7200
			);

			$cap = create_captcha($vals);
			$data['image'] = $cap['image'];
			$this->session->set_userdata('mycaptcha', $cap['word']);
			$this->template->load(template() . '/template', template() . '/register', $data);
		}
	}

	public function profile()
	{
		cek_session_user();
		$profile = $this->db->query("SELECT * FROM users where username='" . $this->session->username . "'")->row_array();
		$data['title'] = $profile['nama_lengkap'];
		$data['description'] = description();
		$data['keywords'] = keywords();
		$data['row'] = $this->db->query("SELECT * FROM users where username='" . $this->session->username . "'")->row_array();
		$this->template->load(template() . '/template', template() . '/profile', $data);
	}

	public function edit_profile()
	{
		cek_session_user();
		if (isset($_POST['submit'])) {
			if ($this->input->post()) {
				$nama_lengkap = $this->input->post('c') . ' ' . $this->input->post('cc');
				if ($this->input->post('b') == '') {
					$data = array(
						'username' => $this->db->escape_str($this->input->post('a')),
						'nama_lengkap' => $nama_lengkap,
						'email' => $this->db->escape_str($this->input->post('d')),
						'no_telp' => $this->db->escape_str($this->input->post('e')),
						'jenis_kelamin' => $this->db->escape_str($this->input->post('kelamin')),
						'alamat_lengkap' => $this->db->escape_str($this->input->post('alamat')),
						'tempat_lahir' => cetak($this->input->post('tempat_lahir')),
						'tanggal_lahir' => cetak($this->input->post('tanggal_lahir')),
						'status_kawin' => cetak($this->input->post('status')),
						'agama' => cetak($this->input->post('agama')),
						// 'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
						'perangkat_daerah' => "Klien"
					);
				} else {
					$data = array(
						'username' => $this->db->escape_str($this->input->post('a')),
						'password' => hash("sha512", md5($this->input->post('b'))),
						'nama_lengkap' => $nama_lengkap,
						'email' => $this->db->escape_str($this->input->post('d')),
						'no_telp' => $this->db->escape_str($this->input->post('e')),
						'foto' => $hasil['file_name'],
						'jenis_kelamin' => $this->db->escape_str($this->input->post('kelamin')),
						'alamat_lengkap' => $this->db->escape_str($this->input->post('alamat')),
						'tempat_lahir' => cetak($this->input->post('tempat_lahir')),
						'tanggal_lahir' => cetak($this->input->post('tanggal_lahir')),
						'status_kawin' => cetak($this->input->post('status')),
						'agama' => cetak($this->input->post('agama')),
						// 'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
						'perangkat_daerah' => "Klien"
					);
				}
				$where = array('username' => $this->session->username);
				$this->model_app->update('users', $data, $where);
			} else {
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Gagal, Terjadi Kesalahan dengan Security Code!!</center></div>');
			}
			redirect('user/profile');
		} else {
			$profile = $this->db->query("SELECT * FROM users where username='" . $this->session->username . "'")->row_array();
			$data['title'] = "Edit Profile";
			$data['description'] = description();
			$data['keywords'] = keywords();

			$this->load->helper('captcha');
			$vals = array(
				'img_path'	 => './captcha/',
				'img_url'	 => base_url() . 'captcha/',
				'font_path' => './asset/Tahoma.ttf',
				'font_size'     => 14,
				'img_width'	 => '90',
				'img_height' => 32,
				'border' => 0,
				'word_length'   => 5,
				'expiration' => 7200
			);

			$cap = create_captcha($vals);
			$data['image'] = $cap['image'];
			$this->session->set_userdata('mycaptcha', $cap['word']);
			$data['row'] = $this->db->query("SELECT * FROM users where username='" . $this->session->username . "'")->row_array();
			$this->template->load(template() . '/template', template() . '/profile_edit', $data);
		}
	}

	function foto()
	{
		cek_session_user();
		if (isset($_POST['submit'])) {
			$config['upload_path'] = 'asset/foto_user/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$config['max_size'] = '3000000'; // kb
			$this->load->library('upload', $config);
			$this->upload->do_upload('f');
			$hasil = $this->upload->data();
			if ($hasil['file_name'] != '') {
				$data = array('foto' => $hasil['file_name']);
				$where = array('username' => $this->session->username);
				$this->model_app->update('users', $data, $where);
			}
			redirect('user/profile');
		} else {
			redirect('user/profile');
		}
	}

	function konsultasi()
	{
		cek_session_user();
		$data['title'] = "List/Data Konsultasi";
		$data['description'] = description();
		$data['keywords'] = keywords();
		$this->template->load(template() . '/template', template() . '/konsultasi', $data);
	}

	function konsultasi_tambah()
	{
		cek_session_user();
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])) {
			if ($this->input->post()) {
				$data = array(
					'id_kategori_konsul' => $this->db->escape_str($this->input->post('a')),
					'user_id' => $this->session->user_id,
					'username' => $this->session->username,
					'judul' => $this->db->escape_str($this->input->post('b')),
					'judul_seo' => seo_title($this->input->post('b')),
					'isi_konsul' => $this->input->post('h'),
					'hari' => hari_ini(date('w')),
					'tanggal' => date('Y-m-d'),
					'jam' => date('H:i:s'),
					'status' => 'N'
				);
				$this->model_app->insert('konsul', $data);
				echo $this->session->set_flashdata('message', '<div class="alert alert-success"><center>Success - Data Konsultasi anda sukses terkirim!!</center></div>');
			} else {
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Gagal, Terjadi Kesalahan dengan Security Code!!</center></div>');
			}
			redirect('user/konsultasi');
		} else {
			$data['title'] = "Tambah List/Data konsultasi";
			$data['description'] = description();
			$data['keywords'] = keywords();
			$data['kategori'] = $this->model_app->view_ordering('kategori_konsul', 'id_kategori_konsul', 'ASC');
			$this->template->load(template() . '/template', template() . '/konsultasi_tambah', $data);
		}
	}

	function konsultasi_edit()
	{
		cek_session_user();
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])) {
			if ($this->input->post()) {
				$data = array(
					'id_kategori_konsul' => $this->db->escape_str($this->input->post('a')),
					'username' => $this->session->username,
					'judul' => $this->db->escape_str($this->input->post('b')),
					'judul_seo' => seo_title($this->input->post('b')),
					'isi_konsul' => $this->input->post('h')
				);
				$where = array('id_konsul' => $this->input->post('id'), 'username' => $this->session->username);
				$this->model_app->update('konsul', $data, $where);
				echo $this->session->set_flashdata('message', '<div class="alert alert-success"><center>Success - Data Konsultasi anda sukses disimpan!!</center></div>');
			} else {
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Gagal, Terjadi Kesalahan dengan Security Code!!</center></div>');
			}
			redirect('user/konsultasi');
		} else {
			$data['title'] = "Edit List/Data konsultasi";
			$data['description'] = description();
			$data['keywords'] = keywords();
			$data['kategori'] = $this->model_app->view_ordering('kategori_konsul', 'id_kategori_konsul', 'ASC');
			$data['rows'] = $this->model_app->edit('konsul', array('id_konsul' => $id))->row_array();
			$this->template->load(template() . '/template', template() . '/konsultasi_edit', $data);
		}
	}

	function konsultasi_delete()
	{
		cek_session_user();
		$id = array('id_konsul' => $this->uri->segment(3), 'username' => $this->session->username);
		$this->model_app->delete('konsul', $id);
		redirect('user/konsultasi');
	}

	function konsultasi_tambahx()
	{
		// cek_session_user();
		if (isset($this->session->level) && !empty($this->session->level)) {
			$data['title'] = "Konsultasi";
			$data['kategori'] = $this->model_app->view_ordering('kategori_konsul', 'id_kategori_konsul', 'ASC');
			$this->template->load(template() . '/template', template() . '/konsultasi_tambahx', $data);
		} else {
			redirect('user/login');
		}
	}

	function konsultasi_proses()
	{
		cek_session_user();
		// print_r($_POST);
		$klinik_id = $this->db->escape_str($_POST['klinik']);
		$dokter_id = $this->db->escape_str($_POST['dokter']);
		$jadwal_selected = $this->db->escape_str($_POST['jadwal_selected']);
		// $kategori = $this->db->escape_str($_POST['kategori']);
		$judul = $this->db->escape_str($_POST['judul']);
		$keluhan = $this->db->escape_str($_POST['keluhan']);
		$consent = $this->db->escape_str($_POST['consent']);

		$timearr = explode(',', $jadwal_selected);
		$tstart = $timearr[0];
		$tend = $timearr[1];
		$jadwal_id = $timearr[2];

		$kuota = $this->model_app->view_where('v_kuota', array('klinik_id' => $klinik_id, 'dokter_id' => $dokter_id, 'id' => $jadwal_id))->result_array();
		$sisa = 0;
		foreach ($kuota as $k) {
			$sisa = $k['sisa'];
		}

		if ($sisa < 0) {
			redirect('user/tambah-konsultasi');
			die();
		}

		if (isset($_POST['submit'])) {
			if ($this->input->post()) {
				$data = array(
					'user_id' => $this->session->user_id,
					'klinik_id' => $klinik_id,
					'username' => $this->session->username,
					'judul' => $judul,
					'judul_seo' => seo_title($judul),
					'isi_konsul' => $keluhan,
					'jadwal_id' => $jadwal_id,
					'hari' => hari_ini(date('w')),
					'tanggal' => date('Y-m-d'),
					'jam' => date('H:i:s'),
					'tstart' => $tstart,
					'tend' => $tend,
					'dokter' => $dokter_id,
					'consent_pasien' => $consent,
					'status' => 'Y'
				);
				$this->model_app->insert('konsul', $data);
				echo $this->session->set_flashdata('message', '<div class="alert alert-success"><center>Success - Data Konsultasi anda sukses terkirim!!</center></div>');
			} else {
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Gagal, Terjadi Kesalahan dengan Security Code!!</center></div>');
			}
			redirect('user/konsultasi');
		}
	}

	function laporan() {}

	// function fetch_klinik()
	// {
	// 	$d = json_decode(file_get_contents("php://input"), TRUE);
	// 	$level = $this->session->level;
	// 	$user_id = $this->session->user_id;

	// 	$d['data']['level'] = $level;
	// 	$d['data']['user_id'] = $user_id;

	// 	$result = $this->model_app->fetch_klinik_3($d);
	// 	// $result['recoms'] = $this->model_app->klinik_rekomendasi();

	// 	for ($i = 0; $i < intval($result['total_rows']); $i++) {
	// 		$idx = $result['items'][$i]['klinik_id'];
	// 		$result['items'][$i]['klinik_idx'] = $this->mylibrary->e101($idx, strlen($idx));
	// 	}
	// 	echo json_encode($result);
	// }

	function klinik()
	{
		$data['title'] = "Daftar Klinik";
		$data['description'] = description();
		$data['keywords'] = keywords();
		$data['klinik'] = $this->db->get('v_klinik')->result_array();
		// var_dump($data['klinik']);
		$this->template->load(template() . '/template', template() . '/list-klinik', $data);
	}

	function fetch_layanan()
	{
		$d = json_decode(file_get_contents("php://input"), TRUE);
		$level = $this->session->level;
		$user_id = $this->session->user_id;

		$d['data']['level'] = $level;
		$d['data']['user_id'] = $user_id;

		$result = $this->model_app->fetch_layanan($d);

		for ($i = 0; $i < intval($result['total_rows']); $i++) {
			$idx = $result['items'][$i]['id_kategori_layanan'];
			$result['items'][$i]['id_kategori_layanan'] = $this->mylibrary->e101($idx, strlen($idx));
		}
		echo json_encode($result);
	}

	function layanan()
	{
		$data['title'] = "Daftar Layanan";
		$data['description'] = description();
		$data['keywords'] = keywords();
		$this->template->load(template() . '/template', template() . '/list-layanan', $data);
	}

	private function set_upload_options()
	{
		$config = array();
		$config['upload_path'] = 'asset/files_inovasi/';
		$config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt|jpeg';
		$config['max_size']	= '3000000'; // kb
		$config['encrypt_name'] = FALSE;
		$this->load->library('upload', $config);
		return $config;
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}
