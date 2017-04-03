<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Classe responsável por realizar as buscas no menu 
  @autor: Henrique Rocha de Souza
 * Data:  31/03/2017
 *  */

class Search extends CI_Controller {

    private $Termo;
    private $ResultLojas;
    private $ResultOcorrencias;
    private $ResultCircuitos;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->Model('Crud');
    }

    public function search() {
        $Termo = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Termo) and ! empty($Termo['termo'])):
            $this->Termo = $Termo['termo'];
            $this->searchLojas($this->Termo);

            if (is_array($this->ResultLojas)):
                foreach ($this->ResultLojas as $lojas):
                    if ($lojas['lj_num'] == '0' or $lojas['lj_num'] == false):
                    else:
                        $this->searchOcorrencias($lojas['lj_num']);
                    endif;
                endforeach;
            else:
                $this->searchCircuitos($this->Termo);
                if (is_array($this->ResultCircuitos)):
                    $this->searchLojas($this->ResultCircuitos[0]['cir_loja']);
                    $this->searchOcorrencias($this->ResultCircuitos[0]['cir_loja']);
                else:
                    $this->searchOcorrencias($this->Termo);
                    if (is_array($this->ResultOcorrencias) and $this->ResultOcorrencias[0] != NULL):
                        var_dump($this->ResultOcorrencias);
                        echo "Chamado";
                        return false;
                    else:
                        if (empty($_SESSION)):
                            session_start();
                        endif;
                        $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
                        $Erro['Msg'] = "Não foram encontrados resultados que coincidam com termo informado.";
                        $this->load->view('errors/Erro', $Erro);
                        return false;
                    endif;
                endif;
            endif;

            if ((!empty($this->ResultLojas)and ! empty($this->ResultOcorrencias)) or ( !empty($this->ResultLojas)and empty($this->ResultOcorrencias))):
                $Results = array();
                $Results['Termo'] = $this->Termo;
                $Results['Lojas'] = $this->ResultLojas;
                $Results['Chamados'] = $this->ResultOcorrencias;
                $this->load->view('Search', $Results);
            else:
                if (empty($_SESSION)):
                    session_start();
                endif;
                $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
                $Erro['Msg'] = "Não foram encontrados resultados que coincidam com termo informado.";
                $this->load->view('errors/Erro', $Erro);
            endif;

        else:
        endif;
    }

    private function searchLojas($Termo) {
        $QR = "select lj_num, lj_end, lj_bairro, lj_cidade, lj_uf from tb_lojas "
                . "where lj_num = '{$Termo}' or lj_end like '%{$Termo}%' or lj_bairro like '%{$Termo}%' or lj_end like '%{$Termo}%' or lj_cidade like '%{$Termo}%'";
        $T = array('o');
        $D = array('i');
        $this->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $this->ResultLojas = $this->Crud->Results['Dados'];
    }

    private function searchCircuitos($Termos) {
        $QR = "select * from tb_circuitos where cir_desig like '%{$Termos}%'";
        $T = array('o');
        $D = array('i');
        $this->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $this->ResultCircuitos = $this->Crud->Results['Dados'];
    }

    private function searchOcorrencias($Termo) {
        $QR = "select o_cod, o_loja, o_desig, o_link, o_prazo, o_opr_ab, o_nece, o_sit_ch from tb_ocorrencias where (o_cod = '{$Termo}' or o_loja = '{$Termo}' or o_desig like '{$Termo}%')";
        $T = array('o');
        $D = array('i');
        $this->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $this->ResultOcorrencias[] = $this->Crud->Results['Dados'];
    }

    private function mountResults() {
//        var_dump($this->ResultLojas);
//        var_dump($this->ResultOcorrencias);
//        var_dump($this->ResultCircuitos);

        $Resutados['Loja'] = array_merge($this->ResultLojas, $this->ResultCircuitos);

        var_dump($Resutados);
    }

}
