<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Crud');
    }
    
    public function admin(){
        $this->Crud->calldb('tb_conf', 'SELECT');
        $Res = $this->Crud->Results;
        $this->load->view('adm', $Res);
    }
    
    public function adminSmsEmail(){        
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);        
        if(!empty($IN) and !empty($IN['status'])):        
            $Field = ($IN['info'] == 'j-sms' ? 'c_sms' : 'c_email');
            $Dados = ($IN['status'] == 'true' ? 'S' : 'N');
            $Change = [
                "{$Field}" => $Dados
            ];
            $where = [
                'c_id' => 1
            ];          
            $this->Crud->calldb('tb_conf', 'UPDATE', $Change, $where);    
            echo $this->Crud->Results;
        endif;
    }
    
    
    public function buscaOcorrencia(){
       $In = filter_input_array(INPUT_GET, FILTER_SANITIZE_NUMBER_INT);        
       if($In['Ch'] != NULL):
           $O = array('o_cod' => $In['Ch']); 
           $this->Crud->calldb('tb_ocorrencias', 'SELECT', $O);
           if($this->Crud->Results['lines'] == 1):
               $this->load->view('ajustesOcorrencias', $this->Crud->Results);
           else:
               die("Ocorrência não encontrada");
           endif;
       else:    
          die("Informação Inválida. Verifique os dados e tente novamente"); 
       endif;
    }
    
    public function UpdateOc(){
        
        
        
        
        
    }
    
}