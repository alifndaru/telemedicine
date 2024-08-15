<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('asset/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class Mypdf {
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function generate($view, $data = array(), $filename = "telemedic-konsul", $paper = 'A4', $orientation = 'potrait') {
        $html = $this->ci->load->view($view, $data, TRUE);
        $dompdf = new Dompdf();
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        
        $dompdf->setOptions($options);   
        $dompdf->loadHtml(ob_get_clean());
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        $dompdf->stream($filename . ".pdf", array('Attachment' => false));
    }
}