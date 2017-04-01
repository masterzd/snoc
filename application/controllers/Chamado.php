<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Chamado extends CI_Controller {

    private $DadosLoja;
    private $Ocorrência;
    private $ContatosSms;
    private $Chamado;
    private $ResultSms;

    function __construct() {
        parent::__construct();
        $this->load->library('sendsms');
        $this->load->helper('url');
        $this->load->model("Crud");
        session_start();
        if (empty($_SESSION['user'])):
            header('Location:' . base_url('Start/?erro=1'));
            return false;
        else:
            if (empty($_SESSION['CtlCh'])):
                $_SESSION['CtlCh'] = array('ChETP1' => 'N', 'ChETP2' => 'N', 'ChETP3' => 'N');
            endif;
        endif;
    }

    public function chamado() {
        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Dados) and ! empty($Dados['o_loja'])):
            $Dados['o_status'] = 'Funcionando_' . $Dados['o_status'];
            /* 1 Etapa: Verifica e levanta os dados da loja que são necessários para a ocorrência */

            if (!empty($_SESSION['InfoCallViewCh'])):
                $this->load->view('nova-ocorrencia', $_SESSION);
                return false;
            endif;

            if (!empty($_SESSION['CtlCh']['ChETP1']) and $_SESSION['CtlCh']['ChETP1'] === 'N'):
                $this->CheckDadosLoja($Dados['o_loja'], $Dados['o_link']);
                if (empty($this->DadosLoja['Loja'])):
                    $Er['erro'] = $this->DadosLoja['mensagem'];
                    $this->load->view('menuprincipal', $Er);
                    return false;
                endif;
            endif;



            /* 2 Etapa: Verifica se existe ocorrência aberta para o link informado */

// 			if(!empty($_SESSION['CtlCh']['ChETP2']) and $_SESSION['CtlCh']['ChETP2'] === 'N'):
// 				
// 				$this->CheckOcorrências($Dados['o_loja'], $Dados['o_link']);
// 				if(!empty($this->Ocorrência['result'])):
// 					$Er['erro'] = $this->Ocorrência['mensagem'];
// 				$this->load->view('menuprincipal', $Er);
// 					return false;
// 				endif;
// 			endif;



            /* 3 Etapa: Grava os dados da ocorrência no banco de dados */;
            if (!empty($_SESSION['CtlCh']['ChETP3']) and $_SESSION['CtlCh']['ChETP3'] === 'N'):
                $Save = $this->Save($Dados);
                if ($Save == true):
                    $this->loadTpAC();
                    $this->enviasms();
                    $this->mostrarChamado();
                else:
                    $Er['erro'] = "Falha ao gravar os dados";
                    $this->load->view('menuprincipal', $Er);
                    return false;
                endif;
            endif;
        endif;
    }

    /* Função para Checar se a loja informada está cadastrada e se está aberta e possui regional cadastrada */

    private function CheckDadosLoja($Loja, $Link) {

        $L = array('lj_num' => $Loja);
        $this->Crud->calldb('tb_lojas', 'SELECT', $L);

        if (is_array($this->Crud->Results)):
            if ($this->Crud->Results['Dados'][0]['lj_sit'] == 'Fechada'):
                $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja encerrou as atividades', 'result' => false);
                return false;
            elseif ($this->Crud->Results['Dados'][0]['r_cod'] == '0'):
                $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui regional cadastrada', 'result' => false);
                return false;
            else:
                $this->DadosLoja['Loja'] = $this->Crud->Results['Dados'][0];
            endif;
        else:
            $this->DadosLoja = array('mensagem' => 'A loja informada não existe', 'result' => false);
            return false;
        endif;

        /* Consultando os  Links da loja informada */
        $L = array('cir_loja' => $Loja, 'cir_link' => $Link);
        $this->Crud->calldb('tb_circuitos', 'SELECT', $L);
        if (is_array($this->Crud->Results)):
            $this->DadosLoja['Link'] = $this->Crud->Results['Dados'][0];
        else:
            $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui o link cadastrado', 'result' => false);
            return false;
        endif;
        /* Consultando todos os links da loja */
        $L = array('cir_loja' => $Loja);
        $this->Crud->calldb('tb_circuitos', 'SELECT', $L);
        if (is_array($this->Crud->Results)):
            $this->DadosLoja['Links'] = $this->Crud->Results['Dados'];
        else:
            $this->DadosLoja = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja não possui o link cadastrado', 'result' => false);
            return false;
        endif;


        /* Consultando contatos para serem enviados via SMS */
        /* Buscando informações na tabela de relacinamentos */
        $Qr = "SELECT * FROM tb_rel_reg WHERE rel_reg = {$this->DadosLoja['Loja']['r_cod']} ORDER BY rel_user ASC";
        $Tbl = array('tb_rel_reg');
        $D = array('ok' => 'ok');
        $this->Crud->calldb($Tbl, 'SELECT', $D, 0, $Qr);
        $InfoReg = $this->Crud->Results['Dados'];

        /* Consultando dados do Diretor Regional */
        $Dr = array('dr_rel' => $InfoReg[0]['rel_user']);
        $this->Crud->calldb('tb_dir_reg', 'SELECT', $Dr);
        $this->ContatosSms['DirReg'] = $this->Crud->Results['Dados'][0]['dr_corp'];

        /* Consultando dados do Gerente Regional */
        $Gr = array('gr_rel' => $InfoReg[1]['rel_user']);
        $this->Crud->calldb('tb_ger_reg', 'SELECT', $Gr);
        $this->ContatosSms['GerReg'] = $this->Crud->Results['Dados'][0]['gr_corp'];
        $this->DadosLoja['Loja']['GerRegName'] = $this->Crud->Results['Dados'][0]['gr_nome'];

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

        $this->Crud->calldb('tb_resp_tec', 'SELECT', $Rt);
        $this->DadosLoja['Loja']['lj_resp_tec']['resp_nome'] = $this->Crud->Results['Dados'][0]['resp_nome'];
        $this->DadosLoja['Loja']['lj_resp_tec']['resp_corp'] = $this->Crud->Results['Dados'][0]['resp_corp'];

        $_SESSION['CtlCh']['ChETP1'] = true;
    }

    /* Função para checar se existe chamado aberto para o link da loja informada */

    private function CheckOcorrências($Loja, $Link) {
        $Tabela = array('tb_ocorrencias');
        $Dad = array('ok', 'ok');
        $Qr = "SELECT o_cod FROM tb_ocorrencias WHERE o_loja = '{$Loja}' AND o_link = '{$Link}' AND o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 7";
        $this->Crud->calldb($Tabela, 'SELECT', $Dad, 0, $Qr);
        if (is_array($this->Crud->Results)):
            $this->Ocorrência = array('mensagem' => 'Não é possível abrir uma ocorrência para a Loja informada. A loja possui uma ocorrência aberta para esse link', 'result' => true);
        else:
            $this->Ocorrência = false;
        endif;
        $_SESSION['CtlCh']['ChETP2'] = true;
    }

    /* Gravando Chamado no banco de dados */

    private function Save(array $DadosCh) {
        $this->Chamado = $DadosCh;
        $this->Chamado['o_uf'] = $this->DadosLoja['Loja']['lj_uf'];
        $this->Chamado['o_reg'] = $this->DadosLoja['Loja']['r_cod'];
        $this->Chamado['o_band'] = $this->DadosLoja['Loja']['b_cod'];
        $this->Chamado['o_sit_ch'] = 0;
        $this->Chamado['o_desig'] = $this->DadosLoja['Link']['cir_desig'];
        $this->Chamado['o_opr_ab'] = $_SESSION['user']['Nome'];
        $this->Chamado['o_hr_ch'] = date("Y-m-d H:i:s");
        $this->Chamado['o_ip_prob'] = $this->DadosLoja['Link']['cir_ip_link'];
        $this->Crud->calldb('tb_ocorrencias', 'INSERT', $this->Chamado);
        $this->Chamado['o_cod'] = $this->Crud->LastInsertID;
        $_SESSION['CtlCh']['ChETP3'] = true;
        return $this->Crud->Results;
    }

    /* Função que faz o envio de sms */

    private function enviasms() {
        $this->ResultSms = $this->sendsms->sms($this->ContatosSms, $this->Chamado, $this->DadosLoja, 1);
    }

    private function loadTpAC() {
        $this->Crud->calldb('tb_tp_prob', 'SELECT', 0);
        $this->Chamado['tp'] = $this->Crud->Results['Dados'];
        $this->Crud->calldb('tb_ac_tomada', 'SELECT', 0);
        $this->Chamado['ac'] = $this->Crud->Results['Dados'];
    }

    private function mostrarChamado() {

        $_SESSION['InfoCallViewCh'] = [
            'DadosCh' => $this->Chamado,
            'DadosLoja' => $this->DadosLoja,
            'Contatos' => $this->ContatosSms,
            'SMS' => $this->ResultSms
        ];

        $this->load->view('nova-ocorrencia', $_SESSION);
    }

}
