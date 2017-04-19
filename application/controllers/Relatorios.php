<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller{
    
    private $Plugin;
    
    
    function __construct() {
        parent::__construct();
        $this->load->Model('Crud');
        $this->load->helper('url');
        
        var_dump($this->uri->uri_string);
        
        if($this->uri->uri_string == 'rel/Geral' or $this->uri->uri_string == 'rel/Sms' or $this->uri->uri_string == 'rel/Loja'):
            require APPPATH."third_party/mpdf60/mpdf.php";
            $this->Plugin = new mPDF($mode, 'A4');
        elseif($this->uri->uri_string == 'rel/DispInter' or $this->uri->uri_string == 'rel/ProdNoc'):
            require APPPATH."third_party/PHPExel/Classes/PHPExcel.php";
            $this->Plugin = new PHPExcel();
        endif;
        
    }
    
    
    public function Geral(){
        
        var_dump($this->Plugin);
        
        
        
        
    }
    
    
    
    
    
    
}