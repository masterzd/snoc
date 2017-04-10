<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShortHand_paginator extends CI_Controller{
    
    private $Offset;
    private $Registros;
    private $Termo;
    private $ResultSet;
            
    function __construct() {
        parent::__construct();
        $this->load->Model('Crud');
    }
    
    public function definePaginator(){        
        $Pg = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(!empty($Pg) and !empty($Pg['pg'])):
            $this->Termo = $Pg['termo'];
            $this->Registros = 6;
            $this->Offset = ($Pg['pg'] - 1)* $this->Registros;
            $this->paginaçãoLojas();
            $this->renderPaginator();
        endif;
    }
    
    public function paginaçãoLojas(){
        $QR = "select lj_num, lj_end, lj_bairro, lj_cidade, lj_uf from tb_lojas "
        . "where lj_num = '{$this->Termo}' or lj_end like '%{$this->Termo}%' or lj_bairro like '%{$this->Termo}%' or lj_end like '%{$this->Termo}%' or lj_cidade like '%{$this->Termo}%' LIMIT {$this->Registros} OFFSET {$this->Offset}";        
        $T = array('o');
        $D = array('i');
        $this->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $this->ResultSet = $this->Crud->Results['Dados'];
    }
    
    private function renderPaginator(){
        
        echo "<tbody class='j-replace'>";
                foreach ($this->ResultSet as $L):
                    echo" <tr>
                        <td>{$L['lj_num']}</td>
                        <td>{$L['lj_end']}</td>
                        <td>{$L['lj_bairro']}</td>
                        <td>{$L['lj_cidade']}</td>
                        <td>{$L['lj_uf']}</td>
                     </tr>";
                endforeach;
        echo" </tbody>";
    }
    
    
  
}