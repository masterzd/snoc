<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Classe responsável por levantar os dados completos das lojas 
  @autor: Henrique Rocha de Souza
 *  Data: 3/04/2017
 *  */

class Infolojas extends CI_Controller {

    private $CI;
    public $DadosLoja;
    public $ContatosSms;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('Crud');
    }

    public function CheckDadosLoja($Loja, $Link = 'MPLS', $Alllinks = true) {

        $L = array('lj_num' => $Loja);
        $this->CI->Crud->calldb('tb_lojas', 'SELECT', $L);

        if (is_array($this->CI->Crud->Results)):
            if ($this->CI->Crud->Results['Dados'][0]['lj_sit'] == 'Fechada' and $this->CI->uri->uri_string != 'consulta-loja'):
                $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja encerrou as atividades', 'result' => false);
                return false;
            elseif ($this->CI->Crud->Results['Dados'][0]['r_cod'] == '0' and $this->CI->uri->uri_string != 'consulta-loja'):
                $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui regional cadastrada', 'result' => false);
                return false;
            else:
                $this->DadosLoja['Loja'] = $this->CI->Crud->Results['Dados'][0];
            endif;
        else:
            $this->DadosLoja = array('mensagem' => 'A loja informada não existe', 'result' => false);
            return false;
        endif;

        if ($Alllinks == true):
            /* Consultando os  Links da loja informada */
            $L = array('cir_loja' => $Loja, 'cir_link' => $Link);
            $this->CI->Crud->calldb('tb_circuitos', 'SELECT', $L);
            if (is_array($this->CI->Crud->Results)):
                $this->DadosLoja['Link'] = $this->CI->Crud->Results['Dados'][0];
            else:
                $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui o link cadastrado', 'result' => false);
                return false;
            endif;
        endif;

        /* Consultando todos os links da loja */
        $L = array('cir_loja' => $Loja);
        $this->CI->Crud->calldb('tb_circuitos', 'SELECT', $L);
        if (is_array($this->CI->Crud->Results)):
            $this->DadosLoja['Links'] = $this->CI->Crud->Results['Dados'];
        else:
            $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui o link cadastrado', 'result' => false);
            return false;
        endif;


        /* Consultando contatos para serem enviados via SMS */
        /* Buscando informações na tabela de relacinamentos */
        $Qr = "SELECT * FROM tb_rel_reg WHERE rel_reg = {$this->DadosLoja['Loja']['r_cod']} ORDER BY rel_user ASC";
        $Tbl = array('tb_rel_reg');
        $D = array('ok' => 'ok');
        $this->CI->Crud->calldb($Tbl, 'SELECT', $D, 0, $Qr);
        $InfoReg = $this->CI->Crud->Results['Dados'];

        /* Consultando dados do Diretor Regional */
        $Dr = array('dr_rel' => $InfoReg[0]['rel_user']);
        $this->CI->Crud->calldb('tb_dir_reg', 'SELECT', $Dr);
        $this->ContatosSms['DirReg'] = $this->CI->Crud->Results['Dados'][0]['dr_corp'];

        /* Consultando dados do Gerente Regional */
        $Gr = array('gr_rel' => $InfoReg[1]['rel_user']);
        $this->CI->Crud->calldb('tb_ger_reg', 'SELECT', $Gr);
        $this->ContatosSms['GerReg'] = $this->CI->Crud->Results['Dados'][0]['gr_corp'];
        $this->DadosLoja['Loja']['GerRegName'] = $this->CI->Crud->Results['Dados'][0]['gr_nome'];

        /* Contato do Gerente da Loja */
        $this->ContatosSms['GerLoja'] = $this->DadosLoja['Loja']['lj_tel_ger'];

        /* Consultando dados do responsável técnico */

        if (($this->DadosLoja['Loja']['b_cod'] == 1 or $this->DadosLoja['Loja']['b_cod'] == 2 or $this->DadosLoja['Loja']['b_cod'] == 7) and ( $this->DadosLoja['Loja']['lj_uf'] == "BA" or $this->DadosLoja['Loja']['lj_uf'] == "SE")):
            $Rt = array('resp_cod' => 8);
        elseif (($this->DadosLoja['Loja']['b_cod'] == 1 or $this->DadosLoja['Loja']['b_cod'] == 2 or $this->DadosLoja['Loja']['b_cod'] == 6 or $this->DadosLoja['Loja']['b_cod'] == 7) and ( $this->DadosLoja['Loja']['lj_uf'] == "AL" or $this->DadosLoja['Loja']['lj_uf'] == "PE" or $this->DadosLoja['Loja']['lj_uf'] == "PB" or $this->DadosLoja['Loja']['lj_uf'] == "RN" or $this->DadosLoja['Loja']['lj_uf'] == "CE")):
            $Rt = array('resp_cod' => 3);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 1 or $this->DadosLoja['Loja']['b_cod'] == 5 or $this->DadosLoja['Loja']['b_cod'] == 7 and ( $this->DadosLoja['Loja']['lj_uf'] == "MA" or $this->DadosLoja['Loja']['lj_uf'] == "PI" or $this->DadosLoja['Loja']['lj_uf'] == "MT" or $this->DadosLoja['Loja']['lj_uf'] == "MS" or $this->DadosLoja['Loja']['lj_uf'] == "RO" or $this->DadosLoja['Loja']['lj_uf'] == "AM" or $this->DadosLoja['Loja']['lj_uf'] == "AC" or $this->DadosLoja['Loja']['lj_uf'] == "RR" or $this->DadosLoja['Loja']['lj_uf'] == "TO" or $this->DadosLoja['Loja']['lj_uf'] == "PA")):
            $Rt = array('resp_cod' => 7);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 2 or $this->DadosLoja['Loja']['b_cod'] == 7 and $this->DadosLoja['Loja']['lj_uf'] == "MG"):
            $Rt = array('resp_cod' => 6);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 2 or $this->DadosLoja['Loja']['b_cod'] == 7 and $this->DadosLoja['Loja']['lj_uf'] == "ES"):
            $Rt = array('resp_cod' => 1);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 2 or $this->DadosLoja['Loja']['b_cod'] == 7 and $this->DadosLoja['Loja']['lj_uf'] == "SP"):
            $Rt = array('resp_cod' => 10);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 2 or $this->DadosLoja['Loja']['b_cod'] == 7 and $this->DadosLoja['Loja']['lj_uf'] == "RJ"):
            $Rt = array('resp_cod' => 2);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 3 or ( $this->DadosLoja['Loja']['b_cod'] == 7 and $this->DadosLoja['Loja']['lj_uf'] == 'GO')):
            $Rt = array('resp_cod' => 5);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 4 or ( $this->DadosLoja['Loja']['b_cod'] == 7 and $this->DadosLoja['Loja']['lj_uf'] == 'PR' or $this->DadosLoja['Loja']['lj_uf'] == 'SC')):
            $Rt = array('resp_cod' => 4);
        elseif ($this->DadosLoja['Loja']['b_cod'] == 8):
            $Rt = array('resp_cod' => 11);
        else:
            $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui um responsável técnico', 'result' => false);
            return false;
        endif;

        $this->CI->Crud->calldb('tb_resp_tec', 'SELECT', $Rt);
        $this->DadosLoja['Loja']['lj_resp_tec']['resp_nome'] = $this->CI->Crud->Results['Dados'][0]['resp_nome'];
        $this->DadosLoja['Loja']['lj_resp_tec']['resp_corp'] = $this->CI->Crud->Results['Dados'][0]['resp_corp'];

        $_SESSION['CtlCh']['ChETP1'] = true;
    }

}
