<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class main_download_pkbi extends CI_Controller {
	public function index(){
		$data['title'] = title();
		$data['description'] = description();
		$data['keywords'] = keywords();

		$jumlah= $this->model_utama->view('berita')->num_rows();
		$config['base_url'] = base_url().'main/index/';
		$config['total_rows'] = $jumlah;
		$config['per_page'] = 5; 	
		if ($this->uri->segment('3')==''){
			$dari = 0;
		}else{
			$dari = $this->uri->segment('3');
		}
		
		if (is_numeric($dari)) {
			$data['berita'] = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('berita.status' => 'Y'),'id_berita','DESC',$dari,$config['per_page']);
			$this->pagination->initialize($config);
		}else{
			redirect('main');
		}

		$this->template->load(template().'/template',template().'/content',$data);
	}
}
