<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashBoard extends CI_Controller{
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Crud');
        $this->load->helper('url');
    }
    
    
    public function Inicio(){
        $this->load->view('dashboard'); 
        
    }
    
    
    
    
    
    
}

