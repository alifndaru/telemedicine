<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		$data['title'] = title();
		$data['description'] = description();
		$data['keywords'] = keywords();

		$data['doctors'] = $this->model_app->view('v_dokter')->result_array();
		$data['total_doctors'] = count($data['doctors']);

		$data['berita'] = $this->model_app->latest_news();
		$data['identitas'] = $this->model_app->view('identitas')->result_array();
		$data['sliders'] = $this->model_app->view_where('slider', array('status' => 'aktif'))->result_array();
		$data['comments'] = $this->model_app->comments5();
		$data['kliniks'] = $this->model_app->view('v_klinik')->result_array();
		$data['total_kliniks'] = count($data['kliniks']);

		$data['kategori_layanan'] = $this->model_app->view('kategori_layanan')->result_array();
		$data['total_kategori_layanan'] = count($data['kategori_layanan']);

		$this->template->load(template() . '/template', template() . '/content-new-2', $data);
		// $this->template->load(template() . '/template', template() . '/content-new-2-copy', $data);
	}
}
