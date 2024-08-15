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

	function lists()
	{
		$jumlah = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user'")->num_rows();
		$config['base_url'] = base_url() . 'psikolog/lists/';
		$config['total_rows'] = $jumlah;
		$config['per_page'] = 5;
		if ($this->uri->segment('3') == '') {
			$dari = 0;
		} else {
			$dari = $this->uri->segment('3');
		}
		$data['title'] = "Daftar Provider Kami";
		$data['description'] = description();
		$data['keywords'] = keywords();
		if (is_numeric($dari)) {
			if (isset($_POST['dokter'])) {
				$dokter = $_POST['dokter'];
				$data['psikolog'] = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user' AND nama_lengkap LIKE '%$dokter%' ORDER BY nama_lengkap DESC LIMIT $dari, $config[per_page]");
			} else {
				$data['psikolog'] = $this->db->query("SELECT * FROM v_jadwal WHERE `level` = 'user' ORDER BY nama_lengkap DESC LIMIT $dari,$config[per_page]");
			}
		} else {
			redirect('main');
		}

		$data['layanan_ipes'] = $this->db->query("SELECT nama_kategori_layanan FROM kategori_layanan WHERE `aktif` = 'Y'")->result_array();
		$this->pagination->initialize($config);
		// $this->template->load(template() . '/template', template() . '/psikolog_list-copy', $data);
		$this->template->load(template() . '/template', template() . '/psikolog_list', $data);
	}
}
