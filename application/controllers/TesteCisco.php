<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TesteCisco extends CI_Controller{
    
    function __construct() {
        parent::__construct( );
        $this->load->helper('url');
        require APPPATH.'third_party/php-cisco_1.0.7/Cisco.php';
    }
    
    
    public function Conecta(){        
        $Router = new Cisco('10.64.9.23','#@#Saved', 'henrique.souza');
        $Router->connect();
        $ARP = $Router->sendSms();
        var_dump($ARP);
    }
    
    
    
    
    
}

