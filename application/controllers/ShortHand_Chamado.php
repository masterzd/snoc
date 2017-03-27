<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShortHand_Chamado extends CI_Controller {
    /*
     * Classe dedicada para funcões que usam Ajax ou post via Js na tela de ocorrências
     * Autor: Henrique Rocha de Souza - Operador TI       
     */

    /* Função que verifica se o link informado para a abertura existe para loja informada */

    public function LinkExistis() {

        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Dados) and !empty($Dados['cir_link'])):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_circuitos', 'SELECT', $Dados);
            $Exe = $this->Crud->Results;

            if (is_array($Exe)):
                echo 'true';
            else:
                echo 'false';
            endif;

        endif;
    }

}
