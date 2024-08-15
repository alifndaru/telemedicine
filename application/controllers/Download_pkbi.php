<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class download_pkbi extends CI_Controller {
	public function index(){
		$jumlah= $this->model_utama->view('download_pkbi')->num_rows();
		$config['base_url'] = base_url().'download/index/';
		$config['total_rows'] = $jumlah;
		$config['per_page'] = 40; 	
		if ($this->uri->segment('3')==''){
			$dari = 0;
		}else{
			$dari = $this->uri->segment('3');
		}
		$data['title'] = "Sekilas PKBIcare";
		
		
		if (is_numeric($dari)) {
			$data['download'] = $this->model_utama->view_ordering_limit('download_pkbi','id_pkbi','DESC',$dari,$config['per_page']);
		}else{
			redirect('main_download_pkbi');
		}
		
		$this->template->load(template().'/template',template().'/download_pkbi',$data);
	}

	
}
