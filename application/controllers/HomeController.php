<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeController extends CI_Controller
{
    public function index()
    {
        // $data['title'] = title();
        $data['description'] = description();
        $data['keywords'] = keywords();

        $this->load->view('home/index', $data);
    }
}
