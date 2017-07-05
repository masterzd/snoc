<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TesteCisco extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        require APPPATH . 'third_party/cisco_ssh/cisco_ssh.php';
    }

    public function Conecta() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ip'])):
            $Router = new cisco_ssh("{$IN['ip']}", 'henrique.souza', 'Isa32:18');
            $Execute = $Router->connect();
            echo $Execute;
        endif;
    }

    public function getPing() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRoute'])):
            if (filter_var($IN['ipDest'], FILTER_VALIDATE_IP) == true and filter_var($IN['ipRoute'], FILTER_VALIDATE_IP) == true):
                $Router = new cisco_ssh("{$IN['ipRoute']}", 'henrique.souza', 'Isa32:18');
                $Router->connect();
               echo $Router->ping($IN['ipDest']);
            endif;
        endif;
    }

}
