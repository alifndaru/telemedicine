<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Konsultasi extends CI_Controller {
	public function detail() {
		$query = $this->model_utama->view_join_two('konsul','users','kategori_konsul','username','id_kategori_konsul',array('konsul.judul_seo' => $this->uri->segment(3),'konsul.status'=>'Y'),'id_konsul','DESC',0,1);
		if ($query->num_rows()<=0){
			redirect('main');
		}else{
			$row = $query->row_array();
			if ($this->session->username==$row['username'] OR $this->session->level=='admin' OR $this->session->level=='user'){
				$data['title'] = cetak($row['judul']);
				$data['description'] = cetak_meta($row['isi_konsul'],0,500);
				$data['keywords'] = cetak($row['judul']);
				$data['rows'] = $row;

				$this->load->helper('captcha');
				$vals = array(
	                'img_path'	 => './captcha/',
	                'img_url'	 => base_url().'captcha/',
	                'font_path' => './asset/Tahoma.ttf',
	                'font_size'     => 14,
	                'img_width'	 => '90',
	                'img_height' => 26,
	                'border' => 0, 
	                'word_length'   => 5,
	                'expiration' => 7200
	            );

	            $cap = create_captcha($vals);
	            $data['image'] = $cap['image'];
	            $this->session->set_userdata('mycaptcha', $cap['word']);
				$this->template->load(template().'/template',template().'/detailkonsul',$data);
			}else{
				redirect('user/konsultasi');
			}
		}
	}

	function xhrLayanan() {
		$d = json_decode(file_get_contents("php://input"), TRUE);
		$r = $this->model_app->xhrLayanan($d['params']);
        $response_arr = array();
        if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "layanan" => $i['layanan']
               );
            }
        }
        echo json_encode($response_arr);
	}

	function detailx() {
		$konsul = $this->model_utama->view_where('v_konsul', array('id_konsul' => $this->uri->segment(3)));
		if ($konsul->num_rows()<=0){
			redirect('main');
		} else {
			$row = $konsul->row_array();
			if ($this->session->username == $row['username'] && $this->session->level == 'inovator') {
				$dokter = $this->model_utama->view_where('v_dokter', array('user_id' => $row['dokter']));
				$pasien = $this->model_utama->view_where('users', array('user_id' => $row['user_id']));
				$data['dokter'] = $dokter->result_array();
				$data['pasien'] = $pasien->row_array();
				$data['title'] = cetak($row['judul']);
				$data['description'] = cetak_meta($row['isi_konsul'],0,500);
				$data['keywords'] = cetak($row['judul']);
				$data['rows'] = $row;
				$this->template->load(template().'/template',template().'/konsul-pasien', $data);
			} else if ($this->session->level == 'admin' OR $this->session->level == 'user' OR $this->session->level == 'klinik') {
				// redirect to home if not dockter auth
				if ($this->session->level == 'user') {
					if ($this->session->user_id !== $row['dokter']) {
						redirect('/');
					}
				}
				$dokter = $this->model_utama->view_where('v_dokter', array('user_id' => $row['dokter']));
				$pasien = $this->model_utama->view_where('users', array('user_id' => $row['user_id']));
				$data['dokter'] = $dokter->row_array();
				$data['pasien'] = $pasien->result_array();
				$data['title'] = cetak($row['judul']);
				$data['description'] = cetak_meta($row['isi_konsul'],0,500);
				$data['keywords'] = cetak($row['judul']);
				$data['rows'] = $row;
				$this->template->load(template().'/template',template().'/konsul-dokter', $data);
			} else {
				redirect('/');
			}
		}
	}

	function history() {
		$kid = $this->uri->segment(3);
		$konsul = $this->model_app->view_where('v_konsul', array('id_konsul' => $kid))->result_array();
		$data['konsul'] = $konsul;

		$this->load->library('mypdf');
		$this->mypdf->generate('pdf/chat2', $data);
		
		// $konsul = $this->model_app->view_where('v_konsul', array('id_konsul' => $kid))->result_array();

		// $data['konsul'] = $konsul;
		// $this->load->view('pdf/chat2', $data);
	}

	function konsul_close() {
		$d = json_decode(file_get_contents("php://input"), TRUE);
		$layanan = implode(",", $d['layanan']);  
		$data = array(
			'catatan_dokter' => $this->db->escape_str($d['catatan']),
			'rujukan' => $this->db->escape_str($d['rujukan']),
			'close_time' => date("Y-m-d H:i:s"),
			'kategori_layanan' => $this->db->escape_str($layanan)
		);
		$this->model_app->update('konsul', $data, array('id_konsul' => $d['konsul_id']));
		$r1 = $this->db->affected_rows();
		$this->model_app->disableKonsul($d['konsul_id']);
		$r2 = $this->db->affected_rows();

		echo json_encode($r1);
	}

	function konsul_chat() {
		$d = json_decode(file_get_contents("php://input"), TRUE);
		$cx = $this->model_utama->view_where('v_konsul', array('id_konsul' => $d['kid']))->result_array();

		$kidx = 0;

		if (isset($d['ref']) || isset($_POST['ref'])) {
			if ($d['ref'] === 'chats') {
				$kidx = $d['kid'];
			}

			if ($d['ref'] === 'kirim') {
				$kidx = $d['kid'];
			}

			if ($_POST['ref'] === 'file') {
				$kidx = $_POST['kid'];
			}
		}

		// if not started yet
		$timeNo = $this->model_app->timeNo($kidx);
		if (count($timeNo) > 0) {
			$cx[0]['statusx'] = 'N0';
		}
		// if the time is starting
		$timeYes = $this->model_app->timeYes($kidx);
		if (count($timeYes) > 0) {
			$cx[0]['statusx'] = 'Y';
		}
		// if expired
		$timeEx = $this->model_app->timeEx($kidx);
		if (count($timeEx) > 0) {
			$this->model_app->disableKonsul($kidx);
			$cx[0]['statusx'] = 'N';
		}
		// check if status N
		if ($cx[0]['status'] === 'N') {
			$cx[0]['statusx'] = 'N';
		} 
		echo json_encode($cx);

		if (isset($d['ref'])) {
			if ($d['ref'] === 'kirim' && $cx[0]['statusx'] === 'Y') {
				if ($this->session->level == 'inovator') { $level = ''; } elseif ($this->session->level == 'admin') { $level = 'Admin'; } else { $level = 'Psikolog'; }
				$data = array('id_konsul' => $d['kid'],
					'nama_komentar'=>$this->session->nama_lengkap.' ('.$this->session->level.')',
					'user_id' => $this->session->user_id,
		            'url'=>$this->session->username,
		            'isi_komentar'=>$d['chat'],
					'type' => 'text',
		            'tgl'=>date('Y-m-d'),
		            'jam_komentar'=>date('H:i:s'),
		            'aktif'=>'Y');
				$this->model_utama->insert('komentar_konsul',$data);
			}

			if ($d['ref'] === 'ambil') {
				$kid = $d['kid'];
				$this->model_app->update('konsul', array('dokter' => $this->session->user_id), "id_konsul = '$kid'");
			}
		}
		
		if (isset($_POST['ref'])) {
			if ($_POST['ref'] === 'file' && isset($_FILES) && $cx[0]['statusx'] === 'Y') {
				$config['upload_path'] = 'asset/foto_konsul/';
				$config['allowed_types'] = 'jpg|png|JPG|JPEG|pdf|PDF';
				$config['max_size'] = '20000000'; // kb
				$config['encrypt_name'] = TRUE;

				$sizeMb = $config['max_size']/1000000;

				$this->load->library('upload', $config);

				if ($_FILES['file']['size'] > $config['max_size']) {
					echo json_encode(array('info' => 'Ukuran file terlalu besar, maksimal ' . $sizeMb . 'MB'));
					die();
				}

				if ($this->upload->do_upload('file')) {
					$hasil = $this->upload->data();
					$foto = $hasil['raw_name'].$hasil['file_ext'];

					if ($this->session->level == 'inovator'){ $level = ''; } elseif ($this->session->level == 'admin') { $level = 'Admin'; } else { $level = 'Psikolog'; }
					$data = array('id_konsul' => $_POST['kid'],
						'nama_komentar'=>$this->session->nama_lengkap.' ('.$this->session->level.')',
						'user_id' => $this->session->user_id,
						'url'=>$this->session->username,
						'isi_komentar'=>'../../asset/foto_konsul/'.$foto,
						'type' => 'file',
						'tgl'=>date('Y-m-d'),
						'jam_komentar'=>date('H:i:s'),
						'aktif'=>'Y');
					if ($this->model_utama->insert('komentar_konsul',$data)) {
						echo json_encode(array('info' => $foto));
					} else {
						echo json_encode(array('info' => 'failed'));
					}
					
				} else {
					echo json_encode(array('info' => 'failed'));
				}
			} else {
				echo json_encode(array('info' => 'failed'));
			}
		}
	}

	function kirim_komentar(){
		if (isset($_POST['submit'])){
			$cek = $this->model_utama->view_where('konsul',array('id_konsul' => $this->input->post('a')));
			$row = $cek->row_array();
			if ($cek->num_rows()<=0){
				redirect('main');
			}else{
				if ($this->input->post() && (strtolower($this->input->post('secutity_code')) == strtolower($this->session->userdata('mycaptcha')))) {
					$cek = $this->db->query("SELECT * FROM users where username='".$this->session->username."'")->row_array();
					if ($cek['level']=='inovator'){ $level = ''; }elseif ($cek['level']=='admin'){ $level = 'Admin'; }else{ $level = 'Psikolog'; }
					$data = array('id_konsul'=>cetak($this->input->post('a')),
		                            'nama_komentar'=>$cek['nama_lengkap'].' ('.$level.')',
									'user_id' => $this->session->user_id,
		                            'url'=>$cek['username'],
		                            'isi_komentar'=>cetak($this->input->post('d')),
		                            'tgl'=>date('Y-m-d'),
		                            'jam_komentar'=>date('H:i:s'),
		                            'aktif'=>'Y',
		                            'email'=>cetak($this->input->post('e')));
					$this->model_utama->insert('komentar_konsul',$data);
				}
			}
			redirect('konsultasi/detail/'.$row['judul_seo'].'#listcomment');

		}
	}

	function unread() {
		$unread = $this->model_app->unread();

		$newarray = array();
		foreach($unread as $key => $value){
			$newarray[$value['id_konsul']][] = $value;
		}

		$ur = array();
		foreach ($newarray as $k => $r) {
			$e = end($r);
			if ($e['level'] == 'P') {
				foreach (array_reverse($r) as $d) {
					if ($k == $d['id_konsul']) {
						if ($d['level'] == 'P') {
							$ur[base_url('konsultasi/detail/').'/'.$k] += 1;
						} else {
							break;
						}
					}
				}
			}
		}

		$all = 0;
		foreach ($ur as $d) {
			$all += $d;
		}

		echo json_encode(array('all' => $all, 'details' => $ur));
	}

	function test() {
		print($_REQUEST);
		echo $this->uri->segment(3);
	}
}
