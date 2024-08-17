<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Provider extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_Doctor');
		$this->load->library('pagination');
	}
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
	public function lists()
	{
		$data['title'] = "Daftar Provider Kami";
		$data['description'] = description();
		$data['keywords'] = keywords();

		$specialization = $this->input->get('spesialis');
		$dari = $this->uri->segment(3, 0);


		// Konfigurasi Pagination
		$config['base_url'] = base_url('provider/lists');
		$config['total_rows'] = $this->Model_Doctor->count_all_doctors('user', $specialization);
		$config['per_page'] = 5;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);

		$data['doctors'] = $this->Model_Doctor->get_dokter('user', $config['per_page'], $dari, $specialization);
		$data['spesialis'] = $this->Model_Doctor->get_specializations();

		$this->template->load(template() . '/template', template() . '/psikolog_list', $data);
	}
}
