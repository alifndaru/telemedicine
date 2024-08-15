<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		
		
    }

	function index(){
		if (isset($_POST['submit'])){
			$username = $this->input->post('a');
			$password = hash("sha512", md5($this->input->post('b')));
			$cek = $this->model_app->cek_login($username, $password, 'users');
		    $row = $cek->row_array();
		    $total = $cek->num_rows();
			if ($total > 0){
				$this->session->set_userdata('upload_image_file_manager',true);
				$this->session->set_userdata(array('username'=>$row['username'],
                                    'nama_lengkap' => $row['nama_lengkap'],
                                    'foto' => $row['foto'],
								    'level'=>$row['level'],
                                    'user_id' => $row['user_id'],
                                    'id_session'=>$row['id_session']));

				redirect('administrator/home');
			}else{
				$data['title'] = 'Username atau Password salah!';
				$this->load->view('administrator/view_login',$data);
			}
		}else{
			$data['title'] = 'Administrator &rsaquo; Log In';
			$this->load->view('administrator/view_login',$data);
		}
		
		
	}

    function reset_password(){
        if (isset($_POST['submit'])){
            $usr = $this->model_app->edit('users', array('id_session' => $this->input->post('id_session')));
            if ($usr->num_rows()>=1){
                if ($this->input->post('a')==$this->input->post('b')){
                    $data = array('password'=>hash("sha512", md5($this->input->post('a'))));
                    $where = array('id_session' => $this->input->post('id_session'));
                    $this->model_app->update('users', $data, $where);

                    $row = $usr->row_array();
                    $this->session->set_userdata('upload_image_file_manager',true);
                    $this->session->set_userdata(array('username'=>$row['username'],
                                       'level'=>$row['level'],
                                       'user_id' => $row['user_id'],
                                       'id_session'=>$row['id_session']));
                    redirect('administrator/home');
                }else{
                    $data['title'] = 'Password Tidak sama!';
                    $this->load->view('administrator/view_reset',$data);
                }
            }else{
                $data['title'] = 'Terjadi Kesalahan!';
                $this->load->view('administrator/view_reset',$data);
            }
        }else{
            $this->session->set_userdata(array('id_session'=>$this->uri->segment(3)));
            $data['title'] = 'Reset Password';
            $this->load->view('administrator/view_reset',$data);
        }
    }

    function lupapassword(){
        if (isset($_POST['lupa'])){
            $email = strip_tags($this->input->post('email'));
            $cekemail = $this->model_app->edit('users', array('email' => $email))->num_rows();
            if ($cekemail <= 0){
                $data['title'] = 'Alamat email tidak ditemukan';
                $this->load->view('administrator/view_login',$data);
            }else{
                $iden = $this->model_app->edit('identitas', array('id_identitas' => 1))->row_array();
                $usr = $this->model_app->edit('users', array('email' => $email))->row_array();
                $this->load->library('email');

                $tgl = date("d-m-Y H:i:s");
                $subject      = 'Lupa Password ...';
                $message      = "<html><body>
                                    <table style='margin-left:25px'>
                                        <tr><td>Halo $usr[nama_lengkap],<br>
                                        Seseorang baru saja meminta untuk mengatur ulang kata sandi Anda di <span style='color:red'>$iden[url]</span>.<br>
                                        Klik di sini untuk mengganti kata sandi Anda.<br>
                                        Atau Anda dapat copas (Copy Paste) url dibawah ini ke address Bar Browser anda :<br>
                                        <a href='".base_url()."administrator/reset_password/$usr[id_session]'>".base_url()."administrator/reset_password/$usr[id_session]</a><br><br>

                                        Tidak meminta penggantian ini?<br>
                                        Jika Anda tidak meminta kata sandi baru, segera beri tahu kami.<br>
                                        Email. $iden[email], No Telp. $iden[no_telp]</td></tr>
                                    </table>
                                </body></html> \n";
                
                $this->email->from($iden['email'], $iden['nama_website']);
                $this->email->to($usr['email']);
                $this->email->cc('');
                $this->email->bcc('');

                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_mailtype("html");
                $this->email->send();
                
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $data['title'] = 'Password terkirim ke '.$usr['email'];
                $this->load->view('administrator/view_login',$data);
            }
        }else{
            redirect('administrator');
        }
    }

    function slider() {
        cek_session_akses('slider', $this->session->id_session);
        if (isset($_POST['submit1']) || isset($_POST['submit2']) || isset($_POST['submit3']) || isset($_POST['submit4']) || isset($_POST['submit5'])) {
            $config['upload_path'] = 'asset/foto_slider/';
            $config['allowed_types'] = 'gif|jpg|png|JPG';
            $config['max_size'] = '2000'; // kb
            $config['overwrite'] = true;

            if (isset($_FILES['i1']) && !empty($_FILES['i1'])) {
                if (!empty($_FILES['i1']['name'])) {
                    $path = $_FILES['i1']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $filename1 = 'slide-1' . '.' . $ext;
                    $config['file_name'] = $filename1;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('i1');
                    $datadb1 = array(
                        'image' => $filename1,
                        'title' => $this->input->post('t1'),
                        'sub_title' => $this->input->post('st1')
                    );
                    $where = array('id' => $this->input->post('id1'));
                    $this->model_app->update('slider', $datadb1, $where);
                }
            }

            if (isset($_FILES['i2']) && !empty($_FILES['i2'])) {
                if (!empty($_FILES['i2']['name'])) {
                    $path = $_FILES['i2']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $filename2 = 'slide-2' . '.' . $ext;
                    $config['file_name'] = $filename2;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('i2');
                    $datadb2 = array(
                        'image' => $filename2,
                        'title' => $this->input->post('t2'),
                        'sub_title' => $this->input->post('st2')
                    );
                    // print_r($datadb2);
                    $where = array('id' => $this->input->post('id2'));
                    $this->model_app->update('slider', $datadb2, $where);
                }
            }
            
            // foreach ($_FILES as $fi => $fv) {
            //     // print_r($fv);
            //     // die();
            //     // slide 1
            //     if ($fi === 'i1') {
            //         if (!empty($fv['name'])) {
            //             $path = $fv['name'];
            //             $ext = pathinfo($path, PATHINFO_EXTENSION);
            //             $filename1 = 'slide-1' . '.' . $ext;
            //             $config['file_name'] = $filename1;
            //             $this->load->library('upload', $config);
            //             $this->upload->do_upload('i1');
            //             $datadb1 = array(
            //                 'image' => $filename1,
            //                 'title' => $this->input->post('t1'),
            //                 'sub_title' => $this->input->post('st1')
            //             );
            //             // print_r($datadb1);
            //             $where = array('id' => $this->input->post('id1'));
            //             $this->model_app->update('slider', $datadb1, $where);
            //             // print_r($datadb1);
            //             // die();
            //         }
            //     }
            //     // slide 2
            //     if ($fi === 'i2') {
            //         if (!empty($fv['name'])) {
            //             $path = $fv['name'];
            //             $ext = pathinfo($path, PATHINFO_EXTENSION);
            //             $filename2 = 'slide-2' . '.' . $ext;
            //             $config['file_name'] = $filename2;
            //             $this->load->library('upload', $config);
            //             $this->upload->do_upload('i2');
            //             $datadb2 = array(
            //                 'image' => $filename2,
            //                 'title' => $this->input->post('t2'),
            //                 'sub_title' => $this->input->post('st2')
            //             );
            //             // print_r($datadb2);
            //             $where = array('id' => $this->input->post('id2'));
            //             $this->model_app->update('slider', $datadb2, $where);
            //         }
            //     }
            //     // slide 3
            //     if ($fi === 'i3') {
            //         if (!empty($fv['name'])) {
            //             $path = $fv['name'];
            //             $ext = pathinfo($path, PATHINFO_EXTENSION);
            //             $filename3 = 'slide-3' . '.' . $ext;
            //             $config['file_name'] = $filename3;
            //             $this->load->library('upload', $config);
            //             $this->upload->do_upload('i3');
            //             $datadb3 = array(
            //                 'image' => $filename3,
            //                 'title' => $this->input->post('t3'),
            //                 'sub_title' => $this->input->post('st3')
            //             );
            //             // print_r($datadb3);
            //             $where = array('id' => $this->input->post('id3'));
            //             $this->model_app->update('slider', $datadb3, $where);
            //         }
            //     }
            //     // slide 4
            //     if ($fi === 'i4') {
            //         if (!empty($fv['name'])) {
            //             $path = $fv['name'];
            //             $ext = pathinfo($path, PATHINFO_EXTENSION);
            //             $filename4 = 'slide-4' . '.' . $ext;
            //             $config['file_name'] = $filename4;
            //             $this->load->library('upload', $config);
            //             $this->upload->do_upload('i4');
            //             $datadb4 = array(
            //                 'image' => $filename4,
            //                 'title' => $this->input->post('t4'),
            //                 'sub_title' => $this->input->post('st4')
            //             );
            //             // print_r($datadb4);
            //             $where = array('id' => $this->input->post('id4'));
            //             $this->model_app->update('slider', $datadb4, $where); 
            //         }
            //     }
            //     // slide 5
            //     if ($fi === 'i5') {
            //         if (!empty($fv['name'])) {
            //             $path = $fv['name'];
            //             $ext = pathinfo($path, PATHINFO_EXTENSION);
            //             $filename5 = 'slide-5' . '.' . $ext;
            //             $config['file_name'] = $filename5;
            //             $this->load->library('upload', $config);
            //             $this->upload->do_upload('i5');
            //             $datadb5 = array(
            //                 'image' => $filename5,
            //                 'title' => $this->input->post('t5'),
            //                 'sub_title' => $this->input->post('st5')
            //             );
            //             // print_r($datadb5);
            //             $where = array('id' => $this->input->post('id5'));
            //             $this->model_app->update('slider', $datadb5, $where);
            //         }
            //     }
            // }
            redirect('administrator/slider');
        } else {
            // echo "ok";
            $data['record'] = $this->model_app->view('slider')->result_array();
            $this->template->load('administrator/template','administrator/mod_slider/add_slider',$data);
        }
    }

    function slider_() {
        echo json_encode($this->model_app->view('slider')->result_array());
    }

    function slider_process() {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $status = $_POST['status'];

        if (empty($_FILES)) {
            $datadb = array(
                'title' => $title,
                'sub_title' => $subtitle,
                'status' => $status
            );
            $where = array('id' => $id);
            $this->model_app->update('slider', $datadb, $where);
            echo json_encode(array('info' => 'berhasil'));
        } else {
            $config['upload_path'] = 'asset/foto_slider/';
            $config['allowed_types'] = 'gif|jpg|png|JPG';
            $config['max_size'] = '20000'; // kb
            // $config['overwrite'] = true;
            $config['encrypt_name'] = TRUE;

            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            // if ($id == 1) {
            //     $filename = 'slide-1' . '.' . $ext;
            // }

            // if ($id == 2) {
            //     $filename = 'slide-2' . '.' . $ext;
            // }

            // if ($id == 3) {
            //     $filename = 'slide-3' . '.' . $ext;
            // }

            // if ($id == 4) {
            //     $filename = 'slide-4' . '.' . $ext;
            // }

            // if ($id == 5) {
            //     $filename = 'slide-5' . '.' . $ext;
            // }

            // $config['file_name'] = $filename;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $dx = $this->model_app->view_where("slider", array("id" => $id))->result_array();
                if (count($dx) > 0) {
                    $fx = $dx[0]['image'];
                    unlink($config['upload_path']  . $fx);
                } 
                $h = $this->upload->data();
                $datadb = array(
                    'image' => $h['file_name'],
                    'title' => $title,
                    'sub_title' => $subtitle,
                    'status' => $status
                );
                $where = array('id' => $id);
                $this->model_app->update('slider', $datadb, $where);
                echo json_encode(array('info' => 'berhasil'));
            } else {
                echo json_encode(array('info' => 'gagal upload file'));
            }
        }
    }

    function laporankonsul() {
        $level = $this->session->level;
        $data['klinik'] = $this->model_app->myKlinik($this->session->user_id);
        if ($level == 'admin' OR $level == 'klinik') {
            // print_r($data);
            $this->template->load('administrator/template','administrator/mod_konsul/view_laporan', $data);
        } else {
            redirect('/');
        }
    }

    function xhrKonsul() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $t = $this->model_app->xhrKonsul($d['params']);
        echo json_encode($t);
    }


    function xhrKonsulExcel() {
        // Load library PHPExcel
        $this->load->library('excel');

        // Create an Object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Setiadi - techack.id | codex.id")
							 ->setLastModifiedBy("Telemedic")
							 ->setTitle("Telemedic")
							 ->setSubject("Telemedic")
							 ->setDescription("Telemedic report by Setiadi - techack.id | codex.id")
							 ->setKeywords("Telemedic")
							 ->setCategory("Report");

        // Create a first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Klinik");
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "ID Pasien");
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Pasien");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "Gender");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', "Tanggal");
        $objPHPExcel->getActiveSheet()->setCellValue('G1', "IPES");

        // Data from database query
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if (isset($d['params'])) {
            $t = $this->model_app->xhrKonsul($d['params']);
        } else {
            $t = $this->model_app->xhrKonsul($_GET);
        }
        $tx = $t['all'];
        $ix = 0;
        $no = 1;

        // Write
        for ($i = 2; $i <= count($tx) + 1; $i++) 
        {
            $objPHPExcel
                ->getActiveSheet()
                    ->setCellValue('A' . $i, $no)
                    ->setCellValue('B' . $i, $tx[$ix]['klinik'])
                    ->setCellValue('C' . $i, $tx[$ix]['user_id'])
                    ->setCellValue('D' . $i, $tx[$ix]['nama_pasien'])
                    ->setCellValue('E' . $i, $tx[$ix]['gender_pasien'])
                    ->setCellValue('F' . $i, $tx[$ix]['tanggalx'])
                    ->setCellValue('G' . $i, $tx[$ix]['kategori_layananx']);
            $ix += 1;
            $no += 1;
        }

        // Save Excel xls File
        $filename="telemedic.xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename);
        return $objWriter->save('php://output');
    }

    function laporan() {
        $level = $this->session->level;

        if ($level == 'admin') {

        }

        if ($level == 'user') {

        }

        if ($level == 'klinik') {

        }

        if ($level == "inovator") {

        }

        $this->template->load('administrator/template','administrator/mod_konsul/view_laporan');
    }

	function home()
	
	{
	
	//echo $this->session->level;	
		//header('refresh: 3; url = http://localhost/telemedic/administrator/home');
		//header("refresh: 3; url = ".base_url('administrator/home'));
        if ($this->session->level=='admin' || $this->session->level=='klinik'){
		  $this->template->load('administrator/template','administrator/view_home_admin');
		
        }
		elseif($this->session->level == "user")
		{
		  header("refresh: 10; url = ".base_url('administrator/home'));
          $data['users'] = $this->model_app->view_where('users',array('username'=>$this->session->username))->row_array();
          $data['modul'] = $this->model_app->view_join_one('users','users_modul','id_session','id_umod','DESC');
          $this->template->load('administrator/template','administrator/view_home_users',$data);
        }
		
		else
		{
			session_destroy();
            header("refresh: 0.00000000000001; url = ".base_url(''));
		}
		
		
	if ($this->session->level == "inovator")
        {
            session_destroy();
            header("/");
        }
	}

	function identitaswebsite(){
		cek_session_akses('identitaswebsite',$this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/images/';
            $config['allowed_types'] = 'gif|jpg|png|ico';
            $config['max_size'] = '500'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('j');
            $hasil=$this->upload->data();

            if ($hasil['file_name']==''){
            	$data = array('nama_website'=>$this->db->escape_str($this->input->post('a')),
                                'email'=>$this->db->escape_str($this->input->post('b')),
                                'url'=>$this->db->escape_str($this->input->post('c')),
                                'facebook'=>$this->input->post('d'),
                                'rekening'=>$this->db->escape_str($this->input->post('e')),
                                'no_telp'=>$this->db->escape_str($this->input->post('f')),
                                'meta_deskripsi'=>$this->input->post('g'),
                                'meta_keyword'=>$this->db->escape_str($this->input->post('h')),
                                'maps'=>$this->input->post('i'));
            }else{
            	$data = array('nama_website'=>$this->db->escape_str($this->input->post('a')),
                                'email'=>$this->db->escape_str($this->input->post('b')),
                                'url'=>$this->db->escape_str($this->input->post('c')),
                                'facebook'=>$this->input->post('d'),
                                'rekening'=>$this->db->escape_str($this->input->post('e')),
                                'no_telp'=>$this->db->escape_str($this->input->post('f')),
                                'meta_deskripsi'=>$this->input->post('g'),
                                'meta_keyword'=>$this->db->escape_str($this->input->post('h')),
                                'favicon'=>$hasil['file_name'],
                                'maps'=>$this->input->post('i'));
            }
	    	$where = array('id_identitas' => $this->input->post('id'));
			$this->model_app->update('identitas', $data, $where);

			redirect('administrator/identitaswebsite');
		}else{
			$proses = $this->model_app->edit('identitas', array('id_identitas' => 1))->row_array();
			$data = array('record' => $proses);
			$this->template->load('administrator/template','administrator/mod_identitas/view_identitas',$data);
		}
	}

	// Controller Modul Menu Website

	function menuwebsite(){
		cek_session_akses('menuwebsite',$this->session->id_session);
		$data['record'] = $this->model_app->view_ordering('menu','urutan','ASC');
		$this->template->load('administrator/template','administrator/mod_menu/view_menu',$data);
	}

	function tambah_menuwebsite(){
		cek_session_akses('menuwebsite',$this->session->id_session);
		if (isset($_POST['submit'])){
			$data = array('id_parent'=>$this->db->escape_str($this->input->post('b')),
                            'nama_menu'=>$this->db->escape_str($this->input->post('c')),
                            'link'=>$this->db->escape_str($this->input->post('a')),
                            'position'=>$this->db->escape_str($this->input->post('d')),
                            'urutan'=>$this->db->escape_str($this->input->post('e')));
			$this->model_app->insert('menu',$data);
			redirect('administrator/menuwebsite');
		}else{
			$proses = $this->model_app->view_where_ordering('menu', array('position' => 'Bottom'), 'id_menu','DESC');
			$data = array('record' => $proses);
			$this->template->load('administrator/template','administrator/mod_menu/view_menu_tambah',$data);
		}
	}

	function edit_menuwebsite(){
		cek_session_akses('menuwebsite',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$data = array('id_parent'=>$this->db->escape_str($this->input->post('b')),
                            'nama_menu'=>$this->db->escape_str($this->input->post('c')),
                            'link'=>$this->db->escape_str($this->input->post('a')),
                            'position'=>$this->db->escape_str($this->input->post('d')),
                            'urutan'=>$this->db->escape_str($this->input->post('e')),
                            'aktif'=>$this->db->escape_str($this->input->post('f')));
			$where = array('id_menu' => $this->input->post('id'));
			$this->model_app->update('menu', $data, $where);
			redirect('administrator/menuwebsite');
		}else{
			$menu_utama = $this->model_app->view_where_ordering('menu', array('position' => 'Bottom'), 'id_menu','DESC');
			$proses = $this->model_app->edit('menu', array('id_menu' => $id))->row_array();
			$data = array('rows' => $proses, 'record' => $menu_utama);
			$this->template->load('administrator/template','administrator/mod_menu/view_menu_edit',$data);
		}
	}

	function delete_menuwebsite(){
        cek_session_akses('menuwebsite',$this->session->id_session);
		$id = array('id_menu' => $this->uri->segment(3));
		$this->model_app->delete('menu',$id);
		redirect('administrator/menuwebsite');
	}


	// Controller Modul Halaman Baru

	function halamanbaru(){
		cek_session_akses('halamanbaru',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('halamanstatis','id_halaman','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('halamanstatis',array('username'=>$this->session->username),'id_halaman','DESC');
        }
		$this->template->load('administrator/template','administrator/mod_halaman/view_halaman',$data);
	}

	function tambah_halamanbaru(){
		cek_session_akses('halamanbaru',$this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_statis/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('c');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('id_kategori_halaman'=>$this->db->escape_str($this->input->post('aa')),
                                    'judul'=>$this->db->escape_str($this->input->post('a')),
                                    'judul_seo'=>seo_title($this->input->post('a')),
                                    'isi_halaman'=>$this->input->post('b'),
                                    'tgl_posting'=>date('Y-m-d'),
                                    'username'=>$this->session->username,
                                    'dibaca'=>'0',
                                    'jam'=>date('H:i:s'),
                                    'hari'=>hari_ini(date('w')),
                                    'urutan_halaman'=>$this->input->post('urutan_halaman'));
            }else{
            		$data = array('id_kategori_halaman'=>$this->db->escape_str($this->input->post('aa')),
                                    'judul'=>$this->db->escape_str($this->input->post('a')),
                                    'judul_seo'=>seo_title($this->input->post('a')),
                                    'isi_halaman'=>$this->input->post('b'),
                                    'tgl_posting'=>date('Y-m-d'),
                                    'gambar'=>$hasil['file_name'],
                                    'username'=>$this->session->username,
                                    'dibaca'=>'0',
                                    'jam'=>date('H:i:s'),
                                    'hari'=>hari_ini(date('w')),
                                    'urutan_halaman'=>$this->input->post('urutan_halaman'));
            }
            $this->model_app->insert('halamanstatis',$data);
			redirect('administrator/halamanbaru');
		}else{
            $data['record'] = $this->model_app->view_ordering('kategori_halaman','id_kategori_halaman','DESC');
			$this->template->load('administrator/template','administrator/mod_halaman/view_halaman_tambah',$data);
		}
	}

	function edit_halamanbaru(){
		cek_session_akses('halamanbaru',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_statis/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('c');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('id_kategori_halaman'=>$this->db->escape_str($this->input->post('aa')),
                                    'judul'=>$this->db->escape_str($this->input->post('a')),
                                    'judul_seo'=>$this->input->post('seo'),
                                    'isi_halaman'=>$this->input->post('b'),
                                    'urutan_halaman'=>$this->input->post('urutan_halaman'));
            }else{
            		$data = array('id_kategori_halaman'=>$this->db->escape_str($this->input->post('aa')),
                                    'judul'=>$this->db->escape_str($this->input->post('a')),
                                    'judul_seo'=>$this->input->post('seo'),
                                    'isi_halaman'=>$this->input->post('b'),
                                    'gambar'=>$hasil['file_name'],
                                    'urutan_halaman'=>$this->input->post('urutan_halaman'));
            }
            $where = array('id_halaman' => $this->input->post('id'));
			$this->model_app->update('halamanstatis', $data, $where);
			redirect('administrator/halamanbaru');
		}else{
            if ($this->session->level=='admin'){
                 $proses = $this->model_app->edit('halamanstatis', array('id_halaman' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('halamanstatis', array('id_halaman' => $id, 'username' => $this->session->username))->row_array();
            }
            $kategori = $this->model_app->view_ordering('kategori_halaman','id_kategori_halaman','DESC');
			$data = array('rows' => $proses, 'record' => $kategori);
			$this->template->load('administrator/template','administrator/mod_halaman/view_halaman_edit',$data);
		}
	}

	function delete_halamanbaru(){
        cek_session_akses('halamanbaru',$this->session->id_session);
		if ($this->session->level=='admin'){
            $id = array('id_halaman' => $this->uri->segment(3));
        }else{
            $id = array('id_halaman' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
		$this->model_app->delete('halamanstatis',$id);
		redirect('administrator/halamanbaru');
	}



    function kategorihalaman(){
        cek_session_akses('kategorihalaman',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('kategori_halaman','id_kategori_halaman','DESC');
        $this->template->load('administrator/template','administrator/mod_kategorihalaman/view_kategori',$data);
    }

    function tambah_kategorihalaman(){
        cek_session_akses('kategorihalaman',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('nama_kategori'=>$this->db->escape_str($this->input->post('a')),
                        'kategori_seo'=>seo_title($this->input->post('a')));
            $this->model_app->insert('kategori_halaman',$data);
            redirect('administrator/kategorihalaman');
        }else{
            $this->template->load('administrator/template','administrator/mod_kategorihalaman/view_kategori_tambah');
        }
    }

    function edit_kategorihalaman(){
        cek_session_akses('kategorihalaman',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama_kategori'=>$this->db->escape_str($this->input->post('a')),
                        'kategori_seo'=>seo_title($this->input->post('a')));
            $where = array('id_kategori_halaman' => $this->input->post('id'));
            $this->model_app->update('kategori_halaman', $data, $where);
            redirect('administrator/kategorihalaman');
        }else{
            $proses = $this->model_app->edit('kategori_halaman', array('id_kategori_halaman' => $id))->row_array();
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_kategorihalaman/view_kategori_edit',$data);
        }
    }

    function delete_kategorihalaman(){
        cek_session_akses('kategorihalaman',$this->session->id_session);
        $id = array('id_kategori_halaman' => $this->uri->segment(3));
        $this->model_app->delete('kategori_halaman',$id);
        redirect('administrator/kategorihalaman');
    }


	// Controller Modul List Berita

	function listberita(){
		cek_session_akses('listberita',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('berita','id_berita','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('berita',array('username'=>$this->session->username),'id_berita','DESC');
        }
        $data['rss'] = $this->model_utama->view_joinn('berita','users','kategori','username','id_kategori','id_berita','DESC',0,10);
        $data['iden'] = $this->model_utama->view_where('identitas',array('id_identitas' => 1))->row_array();
        $this->load->view('administrator/rss',$data);
		$this->template->load('administrator/template','administrator/mod_berita/view_berita',$data);
	}

    function publish_listberita(){
        cek_session_admin();
        if ($this->uri->segment(4)=='Y'){
            $data = array('status'=>'N');
        }else{
            $data = array('status'=>'Y');
        }
        $where = array('id_berita' => $this->uri->segment(3));
        $this->model_app->update('berita', $data, $where);
        redirect('administrator/listberita');
    }

	function tambah_listberita(){
		cek_session_akses('listberita',$this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_berita/';
	        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
	        $config['max_size'] = '3000'; // kb
	        $this->load->library('upload', $config);
	        $this->upload->do_upload('k');
	        $hasil=$this->upload->data();
            
            $config['source_image'] = 'asset/foto_berita/'.$hasil['file_name'];
            $config['wm_text'] = '';
            $config['wm_type'] = 'text';
            $config['wm_font_path'] = './system/fonts/texb.ttf';
            $config['wm_font_size'] = '26';
            $config['wm_font_color'] = 'ffffff';
            $config['wm_vrt_alignment'] = 'middle';
            $config['wm_hor_alignment'] = 'center';
            $config['wm_padding'] = '20';
            $this->load->library('image_lib',$config);
            $this->image_lib->watermark();

            if ($this->session->level == 'kontributor'){ $status = 'N'; }else{ $status = 'Y'; }
            if ($this->input->post('j')!=''){
                $tag_seo = $this->input->post('j');
                $tag=implode(',',$tag_seo);
            }else{
                $tag = '';
            }
            if ($hasil['file_name']==''){
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }else{
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'gambar'=>$hasil['file_name'],
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }
            $this->model_app->insert('berita',$data);
			redirect('administrator/listberita');
		}else{
            $data['record'] = $this->model_app->view_ordering('kategori','id_kategori','DESC');
			$this->template->load('administrator/template','administrator/mod_berita/view_berita_tambah',$data);
		}
	}

	function edit_listberita(){
		cek_session_akses('listberita',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_berita/';
	        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
	        $config['max_size'] = '3000'; // kb
	        $this->load->library('upload', $config);
	        $this->upload->do_upload('k');
	        $hasil=$this->upload->data();

            $config['source_image'] = 'asset/foto_berita/'.$hasil['file_name'];
            $config['wm_text'] = '';
            $config['wm_type'] = 'text';
            $config['wm_font_path'] = './system/fonts/texb.ttf';
            $config['wm_font_size'] = '26';
            $config['wm_font_color'] = 'ffffff';
            $config['wm_vrt_alignment'] = 'middle';
            $config['wm_hor_alignment'] = 'center';
            $config['wm_padding'] = '20';
            $this->load->library('image_lib',$config);
            $this->image_lib->watermark();

            if ($this->session->level == 'kontributor'){ $status = 'N'; }else{ $status = 'Y'; }
            if ($this->input->post('j')!=''){
                $tag_seo = $this->input->post('j');
                $tag=implode(',',$tag_seo);
            }else{
                $tag = '';
            }
            if ($hasil['file_name']==''){
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }else{
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'gambar'=>$hasil['file_name'],
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }
            $where = array('id_berita' => $this->input->post('id'));
			$this->model_app->update('berita', $data, $where);
			redirect('administrator/listberita');
		}else{
            $record = $this->model_app->view_ordering('kategori','id_kategori','DESC');
            if ($this->session->level=='admin'){
                 $proses = $this->model_app->edit('berita', array('id_berita' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('berita', array('id_berita' => $id, 'username' => $this->session->username))->row_array();
            }
			$data = array('rows' => $proses,'tag' => $tag,'record' => $record);
			$this->template->load('administrator/template','administrator/mod_berita/view_berita_edit',$data);
		}
	}

	function delete_listberita(){
        cek_session_akses('listberita',$this->session->id_session);
        if ($this->session->level=='admin'){
    		$id = array('id_berita' => $this->uri->segment(3));
        }else{
            $id = array('id_berita' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
		$this->model_app->delete('berita',$id);
		redirect('administrator/listberita');
	}
	
	// Controller Modul List Telemedicine Informasi

	function listberita_pkbi(){
		cek_session_akses('listberita_pkbi',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('berita_pkbi','id_berita','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('berita_pkbi',array('username'=>$this->session->username),'id_berita','DESC');
        }
        $data['rss'] = $this->model_utama->view_joinn('berita_pkbi','users','kategori_pkbi','username','id_kategori','id_berita','DESC',0,10);
        $data['iden'] = $this->model_utama->view_where('identitas',array('id_identitas' => 1))->row_array();
        $this->load->view('administrator/rss',$data);
		$this->template->load('administrator/template','administrator/mod_berita_pkbi/view_berita',$data);
	}

    function publish_listberita_pkbi(){
        cek_session_admin();
        if ($this->uri->segment(4)=='Y'){
            $data = array('status'=>'N');
        }else{
            $data = array('status'=>'Y');
        }
        $where = array('id_berita' => $this->uri->segment(3));
        $this->model_app->update('berita_pkbi', $data, $where);
        redirect('administrator/listberita_pkbi');
    }

	function tambah_listberita_pkbi(){
		cek_session_akses('listberita_pkbi',$this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_berita/';
	        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
	        $config['max_size'] = '3000'; // kb
	        $this->load->library('upload', $config);
	        $this->upload->do_upload('k');
	        $hasil=$this->upload->data();
            
            $config['source_image'] = 'asset/foto_berita/'.$hasil['file_name'];
            $config['wm_text'] = '';
            $config['wm_type'] = 'text';
            $config['wm_font_path'] = './system/fonts/texb.ttf';
            $config['wm_font_size'] = '26';
            $config['wm_font_color'] = 'ffffff';
            $config['wm_vrt_alignment'] = 'middle';
            $config['wm_hor_alignment'] = 'center';
            $config['wm_padding'] = '20';
            $this->load->library('image_lib',$config);
            $this->image_lib->watermark();

            if ($this->session->level == 'kontributor'){ $status = 'N'; }else{ $status = 'Y'; }
            if ($this->input->post('j')!=''){
                $tag_seo = $this->input->post('j');
                $tag=implode(',',$tag_seo);
            }else{
                $tag = '';
            }
            if ($hasil['file_name']==''){
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }else{
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'gambar'=>$hasil['file_name'],
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }
            $this->model_app->insert('berita_pkbi',$data);
			redirect('administrator/listberita_pkbi');
		}else{
            $data['record'] = $this->model_app->view_ordering('kategori_pkbi','id_kategori','DESC');
			$this->template->load('administrator/template','administrator/mod_berita_pkbi/view_berita_tambah',$data);
		}
	}

	function edit_listberita_pkbi(){
		cek_session_akses('listberita_pkbi',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_berita/';
	        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
	        $config['max_size'] = '3000'; // kb
	        $this->load->library('upload', $config);
	        $this->upload->do_upload('k');
	        $hasil=$this->upload->data();

            $config['source_image'] = 'asset/foto_berita/'.$hasil['file_name'];
            $config['wm_text'] = '';
            $config['wm_type'] = 'text';
            $config['wm_font_path'] = './system/fonts/texb.ttf';
            $config['wm_font_size'] = '26';
            $config['wm_font_color'] = 'ffffff';
            $config['wm_vrt_alignment'] = 'middle';
            $config['wm_hor_alignment'] = 'center';
            $config['wm_padding'] = '20';
            $this->load->library('image_lib',$config);
            $this->image_lib->watermark();

            if ($this->session->level == 'kontributor'){ $status = 'N'; }else{ $status = 'Y'; }
            if ($this->input->post('j')!=''){
                $tag_seo = $this->input->post('j');
                $tag=implode(',',$tag_seo);
            }else{
                $tag = '';
            }
            if ($hasil['file_name']==''){
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }else{
                    $data = array('id_kategori'=>$this->db->escape_str($this->input->post('a')),
                                    'username'=>$this->session->username,
                                    'judul'=>$this->db->escape_str($this->input->post('b')),
                                    'sub_judul'=>$this->db->escape_str($this->input->post('c')),
                                    'youtube'=>$this->db->escape_str($this->input->post('d')),
                                    'judul_seo'=>seo_title($this->input->post('b')),
                                    'headline'=>$this->db->escape_str($this->input->post('e')),
                                    'aktif'=>$this->db->escape_str($this->input->post('f')),
                                    'utama'=>$this->db->escape_str($this->input->post('g')),
                                    'isi_berita'=>$this->input->post('h'),
                                    'hari'=>hari_ini(date('w')),
                                    'tanggal'=>date('Y-m-d'),
                                    'jam'=>date('H:i:s'),
                                    'gambar'=>$hasil['file_name'],
                                    'dibaca'=>'0',
                                    'tag'=>$tag,
                                    'status'=>$status);
            }
            $where = array('id_berita' => $this->input->post('id'));
			$this->model_app->update('berita_pkbi', $data, $where);
			redirect('administrator/listberita_pkbi');
		}else{
            $record = $this->model_app->view_ordering('kategori_pkbi','id_kategori','DESC');
            if ($this->session->level=='admin'){
                 $proses = $this->model_app->edit('berita_pkbi', array('id_berita' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('berita_pkbi', array('id_berita' => $id, 'username' => $this->session->username))->row_array();
            }
			$data = array('rows' => $proses,'tag' => $tag,'record' => $record);
			$this->template->load('administrator/template','administrator/mod_berita_pkbi/view_berita_edit',$data);
		}
	}

	function delete_listberita_pkbi(){
        cek_session_akses('listberita_pkbi',$this->session->id_session);
        if ($this->session->level=='admin'){
    		$id = array('id_berita' => $this->uri->segment(3));
        }else{
            $id = array('id_berita' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
		$this->model_app->delete('berita_pkbi',$id);
		redirect('administrator/listberita_pkbi');
	}


	// Controller Modul Kategori Berita

	function kategoriberita(){
		cek_session_akses('kategoriberita',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('kategori','id_kategori','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('kategori',array('username'=>$this->session->username),'id_kategori','DESC');
        }
		$this->template->load('administrator/template','administrator/mod_kategori/view_kategori',$data);
	}

	function tambah_kategoriberita(){
		cek_session_akses('kategoriberita',$this->session->id_session);
		if (isset($_POST['submit'])){
			$data = array('nama_kategori'=>$this->db->escape_str($this->input->post('a')),
                        'username'=>$this->session->username,
                        'kategori_seo'=>seo_title($this->input->post('a')),
                        'aktif'=>$this->db->escape_str($this->input->post('b')),
                        'sidebar'=>$this->db->escape_str($this->input->post('c')));
			$this->model_app->insert('kategori',$data);
			redirect('administrator/kategoriberita');
		}else{
			$this->template->load('administrator/template','administrator/mod_kategori/view_kategori_tambah');
		}
	}

	function edit_kategoriberita(){
		cek_session_akses('kategoriberita',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$data = array('nama_kategori'=>$this->db->escape_str($this->input->post('a')),
                        'username'=>$this->session->username,
                        'kategori_seo'=>seo_title($this->input->post('a')),
                        'aktif'=>$this->db->escape_str($this->input->post('b')),
                        'sidebar'=>$this->db->escape_str($this->input->post('c')));
			$where = array('id_kategori' => $this->input->post('id'));
			$this->model_app->update('kategori', $data, $where);
			redirect('administrator/kategoriberita');
		}else{
            if ($this->session->level=='admin'){
                 $proses = $this->model_app->edit('kategori', array('id_kategori' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('kategori', array('id_kategori' => $id, 'username' => $this->session->username))->row_array();
            }
			$data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_kategori/view_kategori_edit',$data);
		}
	}

	function delete_kategoriberita(){
		cek_session_akses('kategoriberita',$this->session->id_session);
        if ($this->session->level=='admin'){
            $id = array('id_kategori' => $this->uri->segment(3));
        }else{
            $id = array('id_kategori' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
		$this->model_app->delete('kategori',$id);
		redirect('administrator/kategoriberita');
	}

    // Layanan

    function kategori_layanan(){
        cek_session_akses('kategori_layanan',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('kategori_layanan','id_kategori_layanan','DESC');
        $this->template->load('administrator/template','administrator/mod_kategori_layanan/view_kategori',$data);
    }

		function tambah_kategori_layanan(){
        cek_session_akses('kategori_layanan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array(
                'nama_kategori_layanan'=>$this->db->escape_str($this->input->post('a')),
                'aktif'=>$this->db->escape_str($this->input->post('b')),
                'deskripsi_layanan' => $this->db->escape_str($this->input->post('c'))
            );
            $this->model_app->insert('kategori_layanan',$data);
            redirect('administrator/kategori_layanan');
        }else{
            $this->template->load('administrator/template','administrator/mod_kategori_layanan/view_kategori_tambah');
        }
    }

		function edit_kategori_layanan(){
        cek_session_akses('kategori_layanan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array(
                'nama_kategori_layanan'=>$this->db->escape_str($this->input->post('a')),
                'deskripsi_layanan' => $this->db->escape_str($this->input->post('c')),
                'aktif'=>$this->db->escape_str($this->input->post('b')));
            $where = array('id_kategori_layanan' => $this->input->post('id'));
            $this->model_app->update('kategori_layanan', $data, $where);
            redirect('administrator/kategori_layanan');
        }else{
            $proses = $this->model_app->edit('kategori_layanan', array('id_kategori_layanan' => $id))->row_array();
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_kategori_layanan/view_kategori_edit',$data);
        }
    }

		function delete_kategori_layanan(){
        cek_session_akses('kategori_layanan',$this->session->id_session);
        $id = array('id_kategori_layanan' => $this->uri->segment(3));
        $this->model_app->delete('kategori_layanan',$id);
        redirect('administrator/kategori_layanan');
    }


	// Controller Modul Komentar Berita

	function komentarberita(){
		cek_session_akses('komentarberita',$this->session->id_session);
		$data['record'] = $this->model_app->view_ordering('komentar','id_komentar','DESC');
		$this->template->load('administrator/template','administrator/mod_komentar/view_komentar',$data);
	}

	function edit_komentarberita(){
		cek_session_akses('komentarberita',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$data = array('nama_komentar'=>$this->input->post('a'),
                        'url'=>$this->input->post('b'),
                        'isi_komentar'=>$this->input->post('c'),
                        'aktif'=>$this->input->post('d'),
                        'email'=>$this->input->post('e'));
			$where = array('id_komentar' => $this->input->post('id'));
			$this->model_app->update('komentar', $data, $where);
			redirect('administrator/komentarberita');
		}else{
			$proses = $this->model_app->edit('komentar', array('id_komentar' => $id))->row_array();
			$data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_komentar/view_komentar_edit',$data);
		}
	}

	function delete_komentarberita(){
        cek_session_akses('komentarberita',$this->session->id_session);
		$id = array('id_komentar' => $this->uri->segment(3));
		$this->model_app->delete('komentar',$id);
		redirect('administrator/komentarberita');
	}


    // Controller Modul Iklan Sidebar

    function iklansidebar(){
        cek_session_akses('iklansidebar',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('pasangiklan','id_pasangiklan','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('pasangiklan',array('username'=>$this->session->username),'id_pasangiklan','DESC');
        }
        $this->template->load('administrator/template','administrator/mod_iklansidebar/view_iklansidebar',$data);
    }

    function tambah_iklansidebar(){
        cek_session_akses('iklansidebar',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_pasangiklan/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf';
            $config['max_size'] = '3000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('c');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                'username'=>$this->session->username,
                                'url'=>$this->input->post('b'),
                                'tgl_posting'=>date('Y-m-d'));
            }else{
                $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                'username'=>$this->session->username,
                                'url'=>$this->input->post('b'),
                                'gambar'=>$hasil['file_name'],
                                'tgl_posting'=>date('Y-m-d'));
            }
            $this->model_app->insert('pasangiklan',$data);
            redirect('administrator/iklansidebar');
        }else{
            $this->template->load('administrator/template','administrator/mod_iklansidebar/view_iklansidebar_tambah');
        }
    }

    function edit_iklansidebar(){
        cek_session_akses('iklansidebar',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_pasangiklan/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf';
            $config['max_size'] = '3000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('c');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                'username'=>$this->session->username,
                                'url'=>$this->input->post('b'),
                                'tgl_posting'=>date('Y-m-d'));
            }else{
                $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                'username'=>$this->session->username,
                                'url'=>$this->input->post('b'),
                                'gambar'=>$hasil['file_name'],
                                'tgl_posting'=>date('Y-m-d'));
            }
            $where = array('id_pasangiklan' => $this->input->post('id'));
            $this->model_app->update('pasangiklan', $data, $where);
            redirect('administrator/iklansidebar');
        }else{
            if ($this->session->level=='admin'){
                $proses = $this->model_app->edit('pasangiklan', array('id_pasangiklan' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('pasangiklan', array('id_pasangiklan' => $id, 'username' => $this->session->username))->row_array();
            }
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_iklansidebar/view_iklansidebar_edit',$data);
        }
    }

    function delete_iklansidebar(){
        cek_session_akses('iklansidebar',$this->session->id_session);
        if ($this->session->level=='admin'){
            $id = array('id_pasangiklan' => $this->uri->segment(3));
        }else{
            $id = array('id_pasangiklan' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
        $this->model_app->delete('pasangiklan',$id);
        redirect('administrator/iklansidebar');
    }


    // Controller Modul Logo

    function logowebsite(){
        cek_session_akses('logowebsite',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/logo/';
            $config['allowed_types'] = 'gif|jpg|png|JPG';
            $config['max_size'] = '2000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('logo');
            $hasil=$this->upload->data();
            $datadb = array('gambar'=>$hasil['file_name']);
            $where = array('id_logo' => $this->input->post('id'));
            $this->model_app->update('logo', $datadb, $where);
            redirect('administrator/logowebsite');
        }else{
            $data['record'] = $this->model_app->view('logo');
            $this->template->load('administrator/template','administrator/mod_logowebsite/view_logowebsite',$data);
        }
    }


    // Controller Modul Template Website

    function templatewebsite(){
        cek_session_akses('templatewebsite',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('templates','id_templates','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('templates',array('username'=>$this->session->username),'id_templates','DESC');
        }
        $this->template->load('administrator/template','administrator/mod_template/view_template',$data);
    }

    function tambah_templatewebsite(){
        cek_session_akses('templatewebsite',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                'username'=>$this->session->username,
                                'pembuat'=>$this->input->post('b'),
                                'folder'=>$this->input->post('c'));
            $this->model_app->insert('templates',$data);
            redirect('administrator/templatewebsite');
        }else{
            $this->template->load('administrator/template','administrator/mod_template/view_template_tambah');
        }
    }

    function edit_templatewebsite(){
        cek_session_akses('templatewebsite',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                'username'=>$this->session->username,
                                'pembuat'=>$this->input->post('b'),
                                'folder'=>$this->input->post('c'));
            $where = array('id_templates' => $this->input->post('id'));
            $this->model_app->update('templates', $data, $where);
            redirect('administrator/templatewebsite');
        }else{
            if ($this->session->level=='admin'){
                $proses = $this->model_app->edit('templates', array('id_templates' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('templates', array('id_templates' => $id, 'username' => $this->session->username))->row_array();
            }
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_template/view_template_edit',$data);
        }
    }

    function aktif_templatewebsite(){
        cek_session_akses('templatewebsite',$this->session->id_session);
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4)=='Y'){ $aktif = 'N'; }else{ $aktif = 'Y'; }

        $data = array('aktif'=>$aktif);
        $where = array('id_templates' => $id);
        $this->model_app->update('templates', $data, $where);

        $dataa = array('aktif'=>'N');
        $wheree = array('id_templates !=' => $id);
        $this->model_app->update('templates', $dataa, $wheree);

        redirect('administrator/templatewebsite');
    }

    function delete_templatewebsite(){
        cek_session_akses('templatewebsite',$this->session->id_session);
        if ($this->session->level=='admin'){
            $id = array('id_templates' => $this->uri->segment(3));
        }else{
            $id = array('id_templates' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
        $this->model_app->delete('templates',$id);
        redirect('administrator/templatewebsite');
    }


    // Controller Modul Background

    function background(){
        cek_session_akses('background',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('gambar'=>$this->input->post('a'));
            $where = array('id_background' => 1);
            $this->model_app->update('background', $data, $where);
            redirect('administrator/background');
        }else{
            $proses = $this->model_app->edit('background', array('id_background' => 1))->row_array();
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_background/view_background',$data);
        }
    }


	// Controller Modul Download

	function download(){
		cek_session_akses('download',$this->session->id_session);
		$data['record'] = $this->model_app->view_ordering('download','id_download','DESC');
		$this->template->load('administrator/template','administrator/mod_download/view_download',$data);
	}

	function tambah_download(){
		cek_session_akses('download',$this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt';
            $config['max_size'] = '25000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('b');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'tgl_posting'=>date('Y-m-d'),
                                    'hits'=>'0');
            }else{
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_file'=>$hasil['file_name'],
                                    'tgl_posting'=>date('Y-m-d'),
                                    'hits'=>'0');
            }
            $this->model_app->insert('download',$data);
			redirect('administrator/download');
		}else{
			$this->template->load('administrator/template','administrator/mod_download/view_download_tambah');
		}
	}

	function edit_download(){
		cek_session_akses('download',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt';
            $config['max_size'] = '25000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('b');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')));
            }else{
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_file'=>$hasil['file_name']);
            }
            $where = array('id_download' => $this->input->post('id'));
            $this->model_app->update('download', $data, $where);
			redirect('administrator/download');
		}else{
			$proses = $this->model_app->edit('download', array('id_download' => $id))->row_array();
            $data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_download/view_download_edit',$data);
		}
	}

	function delete_download(){
        cek_session_akses('download',$this->session->id_session);
		$id = array('id_download' => $this->uri->segment(3));
        $this->model_app->delete('download',$id);
		redirect('administrator/download');
	}

    // Controller Modul Menu Informasi PKBI

	function download_pkbi(){
		cek_session_akses('download_pkbi',$this->session->id_session);
		$data['record'] = $this->model_app->view_ordering('download_pkbi','id_pkbi','DESC');
		$this->template->load('administrator/template','administrator/mod_download_pkbi/view_download',$data);
	}

	function tambah_download_pkbi(){
		cek_session_akses('download_pkbi',$this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt';
            $config['max_size'] = '25000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('b');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'tgl_posting'=>date('Y-m-d'),
                                    'hits'=>'0');
            }else{
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_file'=>$hasil['file_name'],
                                    'tgl_posting'=>date('Y-m-d'),
                                    'hits'=>'0');
            }
            $this->model_app->insert('download_pkbi',$data);
			redirect('administrator/download_pkbi');
		}else{
			$this->template->load('administrator/template','administrator/mod_download_pkbi/view_download_tambah');
		}
	}

	function edit_download_pkbi(){
		cek_session_akses('download',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt';
            $config['max_size'] = '25000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('b');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')));
            }else{
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_file'=>$hasil['file_name']);
            }
            $where = array('id_download' => $this->input->post('id'));
            $this->model_app->update('download_pkbi', $data, $where);
			redirect('administrator/download_pkbi');
		}else{
			$proses = $this->model_app->edit('download', array('id_download' => $id))->row_array();
            $data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_download_pkbi/view_download_edit',$data);
		}
	}

	function delete_download_pkbi(){
        cek_session_akses('download_pkbi',$this->session->id_session);
		$id = array('id_download' => $this->uri->segment(3));
        $this->model_app->delete('download_pkbi',$id);
		redirect('administrator/download_pkbi');
	}


    // Controller Modul Alamat

    function alamat(){
        cek_session_akses('alamat',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('alamat'=>$this->input->post('a'));
            $where = array('id_alamat' => 1);
            $this->model_app->update('mod_alamat', $data, $where);
            redirect('administrator/alamat');
        }else{
            $proses = $this->model_app->edit('mod_alamat', array('id_alamat' => 1))->row_array();
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_alamat/view_alamat',$data);
        }
    }


	// Controller Modul Pesan Masuk

	function pesanmasuk(){
		cek_session_akses('pesanmasuk',$this->session->id_session);
		$data['record'] = $this->model_app->view_ordering('hubungi','id_hubungi','DESC');
		$this->template->load('administrator/template','administrator/mod_pesanmasuk/view_pesanmasuk',$data);
	}

	function detail_pesanmasuk(){
		cek_session_akses('pesanmasuk',$this->session->id_session);
		$id = $this->uri->segment(3);
		$this->db->query("UPDATE hubungi SET dibaca='Y' where id_hubungi='$id'");
		if (isset($_POST['submit'])){
			$nama           = $this->input->post('a');
            $email           = $this->input->post('b');
            $subject         = $this->input->post('c');
            $message         = $this->input->post('isi')." <br><hr><br> ".$this->input->post('d');
            
            $this->email->from('robby.prihandaya@gmail.com', 'PHPMU.COM');
            $this->email->to($email);
            $this->email->cc('');
            $this->email->bcc('');

            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_mailtype("html");
            $this->email->send();
            
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
            $this->email->initialize($config);

			$proses = $this->model_app->edit('hubungi', array('id_hubungi' => $id))->row_array();
            $data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_pesanmasuk/view_pesanmasuk_detail',$data);
		}else{
			$proses = $this->model_app->edit('hubungi', array('id_hubungi' => $id))->row_array();
            $data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_pesanmasuk/view_pesanmasuk_detail',$data);
		}
	}

	function delete_pesanmasuk(){
        cek_session_akses('pesanmasuk',$this->session->id_session);
		$id = array('id_hubungi' => $this->uri->segment(3));
        $this->model_app->delete('hubungi',$id);
		redirect('administrator/pesanmasuk');
	}


	// Controller Modul User

	function manajemenuser(){
		cek_session_akses('manajemenuser',$this->session->id_session);
		$data['record'] = $this->model_app->view_ordering('users','username','DESC');
		$this->template->load('administrator/template','administrator/mod_users/view_users',$data);
	}

    function testing() {
        // $t = $this->model_app->last_user_id()->row_array();
        // var_dump(intval($t['id']));

        $last_id = $this->model_app->last_user_id()->row_array();
        $last_id_new = intval($last_id['id']) + 1;
        $user_id = substr_replace("0000", $last_id_new, -strlen($last_id_new));
        echo $user_id;
    }

	function tambah_manajemenuser(){
		cek_session_akses('manajemenuser',$this->session->id_session);
		$id = $this->session->username;
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '1000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();

            // generate user ID
            $last_id = $this->model_app->last_user_id()->row_array();
            $last_id_new = intval($last_id['id']) + 1;
            $user_id_s = substr_replace("0000", $last_id_new, -strlen($last_id_new));
            $user_id = "";
            // $klinik = null;
 
            if ($this->input->post('g') == 'inovator') {
                $user_id = "P-".$user_id_s;
            } elseif ($this->input->post('g') == 'user') {
                $user_id = "D-".$user_id_s;
            } elseif ($this->input->post('g') == 'admin') {
                $user_id = "A-".$user_id_s;
            } elseif ($this->input->post('g') == 'klinik') {
                $user_id = "K-".$user_id_s;
            } else {
                $user_id = "";
            }

            if ($hasil['file_name']==''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telp'=>$this->db->escape_str($this->input->post('e')),
                                    'jenis_kelamin'=>cetak($this->input->post('kelamin')),
                                    'alamat_lengkap'=>cetak($this->input->post('alamat')),
                                    'tempat_lahir'=>cetak($this->input->post('tempat_lahir')),
                                    'tanggal_lahir'=>cetak($this->input->post('tanggal_lahir')),
                                    'status_kawin'=>cetak($this->input->post('status')),
                                    'agama'=>cetak($this->input->post('agama')),
									'str'=>cetak($this->input->post('str')),
									'sip'=>cetak($this->input->post('sip')),
                                    'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
                                    'level'=>$this->db->escape_str($this->input->post('g')),
                                    'klinik_id' => $this->db->escape_str($this->input->post('klinik')),
                                    'blokir'=>'N',
                                    'id_session'=>md5($this->input->post('a')).'-'.date('YmdHis'),
                                    'user_id' => $user_id);
            }else{
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telp'=>$this->db->escape_str($this->input->post('e')),
                                    'jenis_kelamin'=>cetak($this->input->post('kelamin')),
                                    'alamat_lengkap'=>cetak($this->input->post('alamat')),
                                    'tempat_lahir'=>cetak($this->input->post('tempat_lahir')),
                                    'tanggal_lahir'=>cetak($this->input->post('tanggal_lahir')),
                                    'status_kawin'=>cetak($this->input->post('status')),
                                    'agama'=>cetak($this->input->post('agama')),
									'str'=>cetak($this->input->post('str')),
									'sip'=>cetak($this->input->post('sip')),
                                    'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
                                    'foto'=>$hasil['file_name'],
                                    'level'=>$this->db->escape_str($this->input->post('g')),
                                    'klinik_id' => $this->db->escape_str($this->input->post('klinik')),
                                    'blokir'=>'N',
                                    'id_session'=>md5($this->input->post('a')).'-'.date('YmdHis'),
                                    'user_id' => $user_id);
            }
            $this->model_app->insert('users',$data);

              $mod=count($this->input->post('modul'));
              $modul=$this->input->post('modul');
              $sess = md5($this->input->post('a')).'-'.date('YmdHis');
              for($i=0;$i<$mod;$i++){
                $datam = array('id_session'=>$sess,
                              'id_modul'=>$modul[$i]);
                $this->model_app->insert('users_modul',$datam);
              }

			redirect('administrator/edit_manajemenuser/'.$this->input->post('a'));
		}else{
            $proses = $this->model_app->view_where_ordering('modul', array('publish' => 'Y','status' => 'user'), 'id_modul','DESC');
            $data = array('record' => $proses);
			$this->template->load('administrator/template','administrator/mod_users/view_users_tambahx',$data);
		}
	}

	function edit_manajemenuser(){
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/foto_user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '1000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            
            $blokir = $this->db->escape_str($this->input->post('h'));
            if ($blokir === "") {
                $blokir = "N";
            } 
            if ($hasil['file_name']=='' AND $this->input->post('b') ==''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telp'=>$this->db->escape_str($this->input->post('e')),
                                    'jenis_kelamin'=>cetak($this->input->post('kelamin')),
                                    'alamat_lengkap'=>cetak($this->input->post('alamat')),
                                    'tempat_lahir'=>cetak($this->input->post('tempat_lahir')),
                                    'tanggal_lahir'=>cetak($this->input->post('tanggal_lahir')),
                                    'status_kawin'=>cetak($this->input->post('status')),
                                    'agama'=>cetak($this->input->post('agama')),
									'str'=>cetak($this->input->post('str')),
									'sip'=>cetak($this->input->post('sip')),
                                    'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
                                    'klinik_id' => $this->db->escape_str($this->input->post('klinik')),
                                    'blokir'=> $blokir);
            }elseif ($hasil['file_name']!='' AND $this->input->post('b') ==''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telp'=>$this->db->escape_str($this->input->post('e')),
                                    'jenis_kelamin'=>cetak($this->input->post('kelamin')),
                                    'alamat_lengkap'=>cetak($this->input->post('alamat')),
                                    'tempat_lahir'=>cetak($this->input->post('tempat_lahir')),
                                    'tanggal_lahir'=>cetak($this->input->post('tanggal_lahir')),
                                    'status_kawin'=>cetak($this->input->post('status')),
                                    'agama'=>cetak($this->input->post('agama')),
									'str'=>cetak($this->input->post('str')),
									'sip'=>cetak($this->input->post('sip')),
                                    'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
                                    'klinik_id' => $this->db->escape_str($this->input->post('klinik')),
                                    'foto'=>$hasil['file_name'],
                                    'blokir'=>$blokir);
            }elseif ($hasil['file_name']=='' AND $this->input->post('b') !=''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telp'=>$this->db->escape_str($this->input->post('e')),
                                    'jenis_kelamin'=>cetak($this->input->post('kelamin')),
                                    'alamat_lengkap'=>cetak($this->input->post('alamat')),
                                    'tempat_lahir'=>cetak($this->input->post('tempat_lahir')),
                                    'tanggal_lahir'=>cetak($this->input->post('tanggal_lahir')),
                                    'status_kawin'=>cetak($this->input->post('status')),
                                    'agama'=>cetak($this->input->post('agama')),
									'str'=>cetak($this->input->post('str')),
									'sip'=>cetak($this->input->post('sip')),
                                    'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
                                    'klinik_id' => $this->db->escape_str($this->input->post('klinik')),
                                    'blokir'=>$blokir);
            }elseif ($hasil['file_name']!='' AND $this->input->post('b') !=''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telp'=>$this->db->escape_str($this->input->post('e')),
                                    'jenis_kelamin'=>cetak($this->input->post('kelamin')),
                                    'alamat_lengkap'=>cetak($this->input->post('alamat')),
                                    'tempat_lahir'=>cetak($this->input->post('tempat_lahir')),
                                    'tanggal_lahir'=>cetak($this->input->post('tanggal_lahir')),
                                    'status_kawin'=>cetak($this->input->post('status')),
                                    'agama'=>cetak($this->input->post('agama')),
									'str'=>cetak($this->input->post('str')),
									'sip'=>cetak($this->input->post('sip')),
                                    'perangkat_daerah'=>cetak($this->input->post('perangkat_daerah')),
                                    'klinik_id' => $this->db->escape_str($this->input->post('klinik')),
                                    'foto'=>$hasil['file_name'],
                                    'blokir'=>$blokir);
            }
            $where = array('username' => $this->input->post('id'));
            $this->model_app->update('users', $data, $where);

              $mod=count($this->input->post('modul'));
              $modul=$this->input->post('modul');
              for($i=0;$i<$mod;$i++){
                $datam = array('id_session'=>$this->input->post('ids'),
                              'id_modul'=>$modul[$i]);
                $this->model_app->insert('users_modul',$datam);
              }

			redirect('administrator/edit_manajemenuser/'.$this->input->post('id'));
		}else{
            if ($this->session->username==$this->uri->segment(3) OR $this->session->level=='admin'){
                $proses = $this->model_app->edit('users', array('username' => $id))->row_array();
                $akses = $this->model_app->view_join_where('users_modul','modul','id_modul', array('id_session' => $proses['id_session']),'id_umod','DESC');
                $modul = $this->model_app->view_where_ordering('modul', array('publish' => 'Y','status' => 'user'), 'id_modul','DESC');
                $data = array('rows' => $proses, 'record' => $modul, 'akses' => $akses);
    			$this->template->load('administrator/template','administrator/mod_users/view_users_editx',$data);
            }else{
                redirect('administrator/edit_manajemenuser/'.$this->session->username);
            }
		}
	}

	function delete_manajemenuser(){
        cek_session_akses('manajemenuser',$this->session->id_session);
		$id = array('username' => $this->uri->segment(3));
        $this->model_app->delete('users',$id);
		redirect('administrator/manajemenuser');
	}

    function delete_akses(){
        cek_session_admin();
        $id = array('id_umod' => $this->uri->segment(3));
        $this->model_app->delete('users_modul',$id);
        redirect('administrator/edit_manajemenuser/'.$this->uri->segment(4));
    }

	

	// Controller Modul Modul

	function manajemenmodul(){
		cek_session_akses('manajemenmodul',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('modul','id_modul','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('modul',array('username'=>$this->session->username),'id_modul','DESC');
        }
		$this->template->load('administrator/template','administrator/mod_modul/view_modul',$data);
	}

	function tambah_manajemenmodul(){
		cek_session_akses('manajemenmodul',$this->session->id_session);
		if (isset($_POST['submit'])){
			$data = array('nama_modul'=>$this->db->escape_str($this->input->post('a')),
                        'username'=>$this->session->username,
                        'link'=>$this->db->escape_str($this->input->post('b')),
                        'static_content'=>'',
                        'gambar'=>'',
                        'publish'=>$this->db->escape_str($this->input->post('c')),
                        'status'=>$this->db->escape_str($this->input->post('e')),
                        'aktif'=>$this->db->escape_str($this->input->post('d')),
                        'urutan'=>'0',
                        'link_seo'=>'');
            $this->model_app->insert('modul',$data);
			redirect('administrator/manajemenmodul');
		}else{
			$this->template->load('administrator/template','administrator/mod_modul/view_modul_tambah');
		}
	}

	function edit_manajemenmodul(){
		cek_session_akses('manajemenmodul',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
            $data = array('nama_modul'=>$this->db->escape_str($this->input->post('a')),
                        'username'=>$this->session->username,
                        'link'=>$this->db->escape_str($this->input->post('b')),
                        'static_content'=>'',
                        'gambar'=>'',
                        'publish'=>$this->db->escape_str($this->input->post('c')),
                        'status'=>$this->db->escape_str($this->input->post('e')),
                        'aktif'=>$this->db->escape_str($this->input->post('d')),
                        'urutan'=>'0',
                        'link_seo'=>'');
            $where = array('id_modul' => $this->input->post('id'));
            $this->model_app->update('modul', $data, $where);
			redirect('administrator/manajemenmodul');
		}else{
            if ($this->session->level=='admin'){
                 $proses = $this->model_app->edit('modul', array('id_modul' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('modul', array('id_modul' => $id, 'username' => $this->session->username))->row_array();
            }
            $data = array('rows' => $proses);
			$this->template->load('administrator/template','administrator/mod_modul/view_modul_edit',$data);
		}
	}

	function delete_manajemenmodul(){
        cek_session_akses('manajemenmodul',$this->session->id_session);
		if ($this->session->level=='admin') {
            $id = array('id_modul' => $this->uri->segment(3));
        } else {
            $id = array('id_modul' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
        $this->model_app->delete('modul',$id);
		redirect('administrator/manajemenmodul');
	}


    // Controller Modul List Berita

    function konsul(){
        cek_session_akses('konsul',$this->session->id_session);
        $this->template->load('administrator/template','administrator/mod_konsul/view_konsul');
    }

    function delete_konsul(){
        cek_session_akses('konsul',$this->session->id_session);
        $id = array('id_konsul' => $this->uri->segment(3));
        $this->model_app->delete('konsul',$id);
        redirect('administrator/konsul');
    }


    // Controller Modul Kategori Berita

    function kategori_konsul(){
        cek_session_akses('kategori_konsul',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('kategori_konsul','id_kategori_konsul','DESC');
        $this->template->load('administrator/template','administrator/mod_kategori_konsul/view_kategori',$data);
    }

    function tambah_kategori_konsul(){
        cek_session_akses('kategori_konsul',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('nama_kategori'=>$this->db->escape_str($this->input->post('a')),
                        'kategori_seo'=>seo_title($this->input->post('a')),
                        'aktif'=>$this->db->escape_str($this->input->post('b')));
            $this->model_app->insert('kategori_konsul',$data);
            redirect('administrator/kategori_konsul');
        }else{
            $this->template->load('administrator/template','administrator/mod_kategori_konsul/view_kategori_tambah');
        }
    }

    function edit_kategori_konsul(){
        cek_session_akses('kategori_konsul',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama_kategori'=>$this->db->escape_str($this->input->post('a')),
                        'kategori_seo'=>seo_title($this->input->post('a')),
                        'aktif'=>$this->db->escape_str($this->input->post('b')));
            $where = array('id_kategori_konsul' => $this->input->post('id'));
            $this->model_app->update('kategori_konsul', $data, $where);
            redirect('administrator/kategori_konsul');
        }else{
            $proses = $this->model_app->edit('kategori_konsul', array('id_kategori_konsul' => $id))->row_array();
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_kategori_konsul/view_kategori_edit',$data);
        }
    }

    function delete_kategori_konsul(){
        cek_session_akses('kategori_konsul',$this->session->id_session);
        $id = array('id_kategori' => $this->uri->segment(3));
        $this->model_app->delete('kategori_konsul',$id);
        redirect('administrator/kategori_konsul');
    }


    // Controller Modul Komentar Berita

    function komentar_konsul(){
        cek_session_akses('komentar_konsul',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('komentar_konsul','id_komentar','DESC');
        $this->template->load('administrator/template','administrator/mod_komentar_konsul/view_komentar',$data);
    }

    function publish_komentar_konsul(){
        cek_session_admin();
        if ($this->uri->segment(4)=='Y'){
            $data = array('aktif'=>'N');
        }else{
            $data = array('aktif'=>'Y');
        }
        $where = array('id_komentar' => $this->uri->segment(3));
        $this->model_app->update('komentar_konsul', $data, $where);
        redirect('administrator/komentar_konsul');
    }

    function delete_komentar_konsul(){
        cek_session_akses('komentar_konsul',$this->session->id_session);
        $id = array('id_komentar' => $this->uri->segment(3));
        $this->model_app->delete('komentar_konsul',$id);
        redirect('administrator/komentar_konsul');
    }

    function publish_konsul(){
        cek_session_admin();
        if ($this->uri->segment(4)=='Y'){
            $data = array('status'=>'N');
        }else{
            $data = array('status'=>'Y');
        }
        $where = array('id_konsul' => $this->uri->segment(3));
        $this->model_app->update('konsul', $data, $where);
        redirect('administrator/konsul');
    }

	function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}

    // Klinik
    function klinik() {
        cek_session_akses('klinik',$this->session->id_session);
        $this->template->load('administrator/template','administrator/mod_klinik/view_klinik');
    }

    function register_klinik() {
        cek_session_akses('admin',$this->session->id_session);
        $this->template->load('administrator/template','administrator/mod_klinik/view_register_klinik');
    }

    function proses_register_klinik() {
        if (isset($_POST['action'])) {
            // $d = json_decode(file_get_contents("php://input"), TRUE);
            if ($_POST['action'] == 'create') {
                if ($_FILES['foto_klinik']['size'] > 0 && 
                    !empty($_POST['nama_klinik']) &&
                    !empty($_POST['prov_klinik']) &&
                    !empty($_POST['kab_klinik']) &&
                    !empty($_POST['kec_klinik']) &&
                    !empty($_POST['kel_klinik']) &&
                    !empty($_POST['alamat_klinik']) &&
                    !empty($_POST['pos_klinik']) &&
                    !empty($_POST['email_klinik']) &&
                    !empty($_POST['telp_klinik'])) {

                    $config['upload_path'] = 'asset/foto_klinik/';
                    $config['allowed_types'] = 'jpg|png|JPG|JPEG';
                    $config['max_size'] = '1000'; // kb
                    $config['encrypt_name'] = TRUE;
    
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('foto_klinik');
                    $hasil=$this->upload->data();
                    $foto = $hasil['raw_name'].$hasil['file_ext'];
    
                    $data_klinik = array('klinik'=>$this->db->escape_str($this->input->post('nama_klinik')),
                                'provinsi_id'=>$this->db->escape_str($this->input->post('prov_klinik')),
                                'kabupaten_id'=>$this->db->escape_str($this->input->post('kab_klinik')),
                                'kecamatan_id'=>$this->db->escape_str($this->input->post('kec_klinik')),
                                'kelurahan_id'=>$this->db->escape_str($this->input->post('kel_klinik')),
                                'alamat'=>$this->db->escape_str($this->input->post('alamat_klinik')), 
                                'pos'=>$this->db->escape_str($this->input->post('pos_klinik')),
                                'email'=>$this->db->escape_str($this->input->post('email_klinik')),
                                'phone'=>$this->db->escape_str($this->input->post('telp_klinik')),
                                'foto'=> $foto);
                    $this->model_app->insert('klinik', $data_klinik);
                    redirect('administrator/klinik');
                } else {
                    redirect('administrator/klinik');
                }
            }

            if ($_POST['action'] == 'update') {
                if (!empty($_POST['nama_klinik']) &&
                    !empty($_POST['prov_klinik']) &&
                    !empty($_POST['kab_klinik']) &&
                    !empty($_POST['kec_klinik']) &&
                    !empty($_POST['kel_klinik']) &&
                    !empty($_POST['alamat_klinik']) &&
                    !empty($_POST['pos_klinik']) &&
                    !empty($_POST['email_klinik']) &&
                    !empty($_POST['telp_klinik'])) {

                    $kid = $_POST['kid'];

                    if ($_FILES['foto_klinik']['size'] > 0) {
                        $config['upload_path'] = 'asset/foto_klinik/';
                        $config['allowed_types'] = 'jpg|png|JPG|JPEG';
                        $config['max_size'] = '1000'; // kb
                        $config['encrypt_name'] = TRUE;

                        $this->load->library('upload', $config);
                        $this->upload->do_upload('foto_klinik');
                        $hasil=$this->upload->data();
                        $foto = $hasil['raw_name'].$hasil['file_ext'];

                        $data_klinik = array('klinik'=>$this->db->escape_str($this->input->post('nama_klinik')),
                            'provinsi_id'=>$this->db->escape_str($this->input->post('prov_klinik')),
                            'kabupaten_id'=>$this->db->escape_str($this->input->post('kab_klinik')),
                            'kecamatan_id'=>$this->db->escape_str($this->input->post('kec_klinik')),
                            'kelurahan_id'=>$this->db->escape_str($this->input->post('kel_klinik')),
                            'alamat'=>$this->db->escape_str($this->input->post('alamat_klinik')), 
                            'pos'=>$this->db->escape_str($this->input->post('pos_klinik')),
                            'email'=>$this->db->escape_str($this->input->post('email_klinik')),
                            'phone'=>$this->db->escape_str($this->input->post('telp_klinik')),
                            'foto'=> $foto);
                        $this->model_app->update('klinik', $data_klinik, "id = $kid");
                        redirect('administrator/klinik');
                    } else {
                        $data_klinik = array('klinik'=>$this->db->escape_str($this->input->post('nama_klinik')),
                            'provinsi_id'=>$this->db->escape_str($this->input->post('prov_klinik')),
                            'kabupaten_id'=>$this->db->escape_str($this->input->post('kab_klinik')),
                            'kecamatan_id'=>$this->db->escape_str($this->input->post('kec_klinik')),
                            'kelurahan_id'=>$this->db->escape_str($this->input->post('kel_klinik')),
                            'alamat'=>$this->db->escape_str($this->input->post('alamat_klinik')), 
                            'pos'=>$this->db->escape_str($this->input->post('pos_klinik')),
                            'email'=>$this->db->escape_str($this->input->post('email_klinik')),
                            'phone'=>$this->db->escape_str($this->input->post('telp_klinik')));
                        $this->model_app->update('klinik', $data_klinik, "id = $kid");
                        redirect('administrator/klinik');
                    }
                }
            }
        }
    }

    function fetch_klinik() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $level = $this->session->level;
        $user_id = $this->session->user_id;

        $d['data']['level'] = $level;
        $d['data']['user_id'] = $user_id;

        if ($level === 'klinik') {
            $result = $this->model_app->fetch_klinik_2($d);
        } else {
            $result = $this->model_app->fetch_klinik($d);
        }
        
        for ($i = 0; $i < intval($result['total_rows']); $i++) {
            $idx = $result['items'][$i]['klinik_id'];
            $result['items'][$i]['klinik_idx'] = $this->mylibrary->e101($idx, strlen($idx));
        }
        echo json_encode($result);
    }

    function fetch_single_klinik() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        echo json_encode($this->model_app->fetch_single_klinik($d['data']['kid']));
    }

    function status_klinik() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $id = $d['data']['id'];
        $status = $d['data']['status'];

        echo $status;

        if (!empty($id) && !empty($status)) {
            if ($status == 'aktif') {
                $data_klinik = array('status' => 'tidak aktif');
            } else {
                $data_klinik = array('status' => 'aktif');
            }
            $this->model_app->update('klinik', $data_klinik, "id = $id");
            echo json_encode($this->model_app->fetch_single_klinik($id));
        }
    }

    function testt () {

        
        // $params = array(
        //     'search' => 'a',
        //     'ref' => 'provinsi'
        // );

        // $data = $this->model_app->xhrRefPemda($params);
        // print_r($data);

        // $data = $this->model_app->allKlinik();
        // print_r($data);
        // $ts = random_string('alnum', 101);
        // $tsx = substr_replace($ts, "7", 53, 1);
        // echo $tsx;
        // echo "<br>";
        // echo substr($tsx, 53, 1);
        $idx = 9955;
        $item = $this->mylibrary->e101($idx, strlen($idx));
        echo $this->mylibrary->d101($item, $this->mylibrary->l101($item));
    }

    function edit_klinik() {
        if (isset($_GET['kid'])) {
            $kid = $_GET['kid'];
            $data['kid'] = $this->mylibrary->d101($kid, $this->mylibrary->l101($kid));
            cek_session_akses('klinik',$this->session->id_session);
            $this->template->load('administrator/template','administrator/mod_klinik/view_edit_klinik', $data);
        }
    }

    public function xhrDokter() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $response_arr = array();

        if ($d['params']['ref'] === 'dokter') {
            $r = $this->model_app->xhrDokter($d['params']);
            if (count($r['res']) > 0) {
                foreach ($r['res'] as $i) {
                    $response_arr[] = array(
                        "id" => $i['user_id'],
                        "dokter" => $i['nama_lengkap']
                    );
                }
            }
        }

        if ($d['params']['ref'] === 'dokter-klinik') {
            $r = $this->model_app->xhrDokter($d['params']);
            if (count($r['res']) > 0) {
                foreach ($r['res'] as $i) {
                    $response_arr[] = array(
                        "id" => $i['dokter_id'],
                        "dokter" => $i['nama_lengkap'],
                        'foto_dokter' => $i['foto_dokter'],
                        'klinik' => $i['klinik'],
                        'jabatan' => $i['jabatan']
                    );
                }
            }
        }

        if ($d['params']['ref'] === 'dokter-jadwal') {
            $response_arr = $this->model_app->xhrDokter($d['params']);
        }
        
        echo json_encode($response_arr);
    }

    function xhrJadwalDokter() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if ($d['data']['ref'] === 'semua') {
            echo json_encode($this->model_app->xhrJadwalx($d));
        }
    }

    function xhrJadwal() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        if ($d['data']['ref'] === 'tambah') {
            $dt = array(
                'klinik_id' => $d['data']['klinik_id'],
                'dokter_id' => $d['data']['dokter_id'],
                'tstart' => $d['data']['tstart'],
                'tend' => $d['data']['tend'],
                'kuota' => $d['data']['kuota'],
                'timezone' => $d['data']['timezone'],
                'status' => $d['data']['timestatus']
            );
            $this->model_app->insert('klinik_waktu_dokter', $dt);
        }

        if ($d['data']['ref'] === 'status') {
            $id = $d['data']['id'];
            $status = $d['data']['status'];
            if (!empty($id) && !empty($status)) {
                if ($status == 'aktif') {
                    $dx = array('status' => 'tidak aktif');
                } else {
                    $dx = array('status' => 'aktif');
                }
                $this->model_app->update('klinik_waktu_dokter', $dx, "id = $id");
            }
        }

        if ($d['data']['ref'] === 'delete') {
            $id = $d['data']['id'];
            $this->model_app->delete('klinik_waktu_dokter', "id = $id");
        }

        if ($d['data']['ref'] === 'edit') {
            $id = $d['data']['id'];
            $dt = array(
                'klinik_id' => $d['data']['klinik_id'],
                'dokter_id' => $d['data']['dokter_id'],
                'tstart' => $d['data']['tstart'],
                'tend' => $d['data']['tend'],
                'kuota' => $d['data']['kuota'],
                'timezone' => $d['data']['timezone'],
                'status' => $d['data']['timestatus']
            );
            $this->model_app->update('klinik_waktu_dokter', $dt, "id = '$id'");
        }
    }

    // Pemda
    public function xhrRefPemda() {
      $d = json_decode(file_get_contents("php://input"), TRUE);
      $r = $this->model_app->xhrRefPemda($d['params']);
      $response_arr = array();
      if ($r['ref'] === 'provinsi') {
         if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "provinsi" => $i['provinsi']
               );
            }
         }
      }

      if ($r['ref'] === 'kabupaten') {
         if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "kabupaten" => $i['kabupaten']
               );
            }
         }
      }

      if ($r['ref'] === 'kecamatan') {
         if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "kecamatan" => $i['kecamatan']
               );
            }
         }
      }

      if ($r['ref'] === 'kelurahan') {
         if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "kelurahan" => $i['kelurahan']
               );
            }
         }
      }

      echo json_encode($response_arr);
    }

    function xhrKlinik() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $r = $this->model_app->xhrKlinik($d['params']);
        $response_arr = array();
        if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "klinik" => $i['klinik']
               );
            }
        }
        echo json_encode($response_arr);
    }

    function xhrMyKlinik() {
        $d = json_decode(file_get_contents("php://input"), TRUE);
        $r = $this->model_app->xhrMyKlinik($d['params']);
        $response_arr = array();
        if (count($r['res']) > 0) {
            foreach ($r['res'] as $i) {
               $response_arr[] = array(
                  "id" => $i['id'],
                  "klinik" => $i['klinik']
               );
            }
        }
        echo json_encode($response_arr);
    }

    // manajemen dokter
    public function dokter() {
        if (isset($_GET['kid'])) {
            $kid = $_GET['kid'];
            $data['kid'] = $this->mylibrary->d101($kid, $this->mylibrary->l101($kid));
            cek_session_akses('klinik',$this->session->id_session);
            $this->template->load('administrator/template','administrator/mod_klinik/view_manajemen_dokter', $data);
        }
    }
	
	
}
