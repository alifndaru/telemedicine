<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Psikolog extends CI_Controller
{
	function index()
	{
		if (isset($_POST['submit'])) {
			$username = $this->input->post('a');
			$password = hash("sha512", md5($this->input->post('b')));
			$cek = $this->model_app->cek_login($username, $password, 'users');
			$row = $cek->row_array();
			$total = $cek->num_rows();
			if ($total > 0) {
				$this->session->set_userdata('upload_image_file_manager', true);
				$this->session->set_userdata(array(
					'username' => $row['username'],
					'level' => $row['level'],
					'foto' => $row['foto'],
					'nama_lengkap' => $row['nama_lengkap'],
					'user_id' => $row['user_id'],
					'id_session' => $row['id_session']
				));

				redirect('administrator/home');
			} else {
				$data['title'] = 'Username atau Password salah!';
				$this->load->view('administrator/view_login', $data);
			}
		} else {
			$data['title'] = 'Psikolog &rsaquo; Log In';
			$this->load->view('administrator/view_login_psikolog', $data);
		}
	}

	// function lists()
	// {
	// 	$jumlah = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user'")->num_rows();
	// 	$config['base_url'] = base_url() . 'psikolog/lists/';
	// 	$config['total_rows'] = $jumlah;
	// 	$config['per_page'] = 5;
	// 	if ($this->uri->segment('3') == '') {
	// 		$dari = 0;
	// 	} else {
	// 		$dari = $this->uri->segment('3');
	// 	}
	// 	$data['title'] = "Daftar Provider Kami";
	// 	$data['description'] = description();
	// 	$data['keywords'] = keywords();

	// 	$this->db->select('users.*, klinik.klinik');
	// 	$this->db->from('users');
	// 	$this->db->join('klinik', 'klinik.id = users.klinik_id');
	// 	$this->db->where('users.level', 'user');
	// 	$this->db->limit($config['per_page'], $dari);
	// 	$query = $this->db->get();
	// 	$data['doctors'] = $query->result_array();




	// 	// $data['psikolog'] = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user' AND nama_lengkap LIKE '%$dokter%' ORDER BY nama_lengkap DESC LIMIT $dari, $config[per_page]");

	// 	// if (is_numeric($dari)) {
	// 	// 	if (isset($_POST['dokter'])) {
	// 	// 		$dokter = $_POST['dokter'];
	// 	// 		$data['psikolog'] = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user' AND nama_lengkap LIKE '%$dokter%' ORDER BY nama_lengkap DESC LIMIT $dari, $config[per_page]");
	// 	// 	} else {
	// 	// 		$data['psikolog'] = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user' ORDER BY nama_lengkap DESC LIMIT $dari,$config[per_page]");
	// 	// 	}
	// 	// } else {
	// 	// 	redirect('main');
	// 	// }

	// 	$data['jabatan'] = $this->db->query("SELECT DISTINCT jabatan FROM v_jadwal WHERE jabatan IN ('Dokter Spesialis', 'Dokter Umum', 'Bidan', 'Perawat', 'Konselor Psikologi', 'Konselor Remaja / Sebaya', 'Dokter Spesialis Penyakit Dalam')")->result_array();

	// 	$this->pagination->initialize($config);
	// 	// $this->template->load(template() . '/template', template() . '/psikolog_list-copy', $data);
	// 	$this->template->load(template() . '/template', template() . '/psikolog_list', $data);
	// }

	// function lists()
	// {
	// 	$spesialis = $this->input->get('spesialis'); // Mengambil spesialis dari parameter GET

	// 	$jumlah = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user'")->num_rows();
	// 	$config['base_url'] = base_url() . 'psikolog/lists/';
	// 	$config['total_rows'] = $jumlah;
	// 	$config['per_page'] = 5;
	// 	$dari = $this->uri->segment(3, 0);

	// 	$data['title'] = "Daftar Provider Kami";
	// 	$data['description'] = description();
	// 	$data['keywords'] = keywords();

	// 	// Query untuk mengambil dokter
	// 	$this->db->select('users.*, klinik.klinik');
	// 	$this->db->from('users');
	// 	$this->db->join('klinik', 'klinik.id = users.klinik_id');
	// 	$this->db->where('users.level', 'user');

	// 	// Filter berdasarkan spesialisasi jika ada
	// 	if (!empty($spesialis)) {
	// 		$this->db->where('users.spesialis', $spesialis);
	// 	}

	// 	$this->db->limit($config['per_page'], $dari);
	// 	$query = $this->db->get();
	// 	$data['doctors'] = $query->result_array();

	// 	$data['jabatan'] = $this->db->query("SELECT DISTINCT jabatan FROM v_jadwal WHERE jabatan IN ('Dokter Spesialis', 'Dokter Umum', 'Bidan', 'Perawat', 'Konselor Psikologi', 'Konselor Remaja / Sebaya', 'Dokter Spesialis Penyakit Dalam')")->result_array();

	// 	$this->pagination->initialize($config);
	// 	$this->template->load(template() . '/template', template() . '/psikolog_list', $data);
	// }

	function lists()
	{
		$spesialis = $this->input->get('spesialis'); // Mengambil spesialis dari parameter GET

		$this->db->from('users');
		$this->db->where('level', 'user');
		if (!empty($spesialis)) {
			$this->db->where('spesialis', $spesialis);
		}
		$jumlah = $this->db->count_all_results(); // Menghitung total rows dengan filter

		$config['base_url'] = base_url() . 'psikolog/lists/';
		$config['total_rows'] = $jumlah;
		$config['per_page'] = 5;
		$dari = $this->uri->segment(3, 0);

		$data['title'] = "Daftar Provider Kami";
		$data['description'] = description();
		$data['keywords'] = keywords();

		// Query untuk mengambil dokter
		$this->db->select('users.*, klinik.klinik');
		$this->db->from('users');
		$this->db->join('klinik', 'klinik.id = users.klinik_id');
		$this->db->where('users.level', 'user');
		if (!empty($spesialis)) {
			$this->db->where('users.spesialis', $spesialis);
		}
		$this->db->limit($config['per_page'], $dari);
		$query = $this->db->get();
		$data['doctors'] = $query->result_array();

		// Ambil daftar spesialis yang tersedia
		$data['jabatan'] = $this->db->query("SELECT DISTINCT spesialis FROM users WHERE spesialis IS NOT NULL")->result_array();

		$this->pagination->initialize($config);
		$this->template->load(template() . '/template', template() . '/psikolog_list', $data);
	}
}
