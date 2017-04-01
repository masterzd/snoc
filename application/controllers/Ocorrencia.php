<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ocorrencia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Crud');
    }
    
    public function ConsultaCh(){       
      $Ch = (int) $this->input->get('Ch');
      if($Ch == NULL):
          die('Parametro inválido');
      endif;      
      /* Pesquisando Ocorrência */
      $Chamado = array('o_cod' => $Ch);
      $this->Crud->calldb('tb_ocorrencias', 'SELECT', $Chamado);
      $Ocorrencia = $this->Crud->Results['Dados'][0]; 
      
      /* Pesquisando numero da loja */
      $Lj = array('lj_num' => $Ocorrencia['o_loja']);
      $this->Crud->calldb('tb_lojas', 'SELECT', $Chamado);
      
      var_dump($Ocorrencia);
      
      
        
    }
    
    

}
