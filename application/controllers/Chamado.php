<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Chamado extends CI_Controller {

    public  $DadosLoja;
    private $Ocorrência;
    private $ContatosSms;
    private $Chamado;
    private $ResultSms;

    function __construct() {        
        parent::__construct();
        $this->load->model('Crud'); 
        $this->load->library('sendsms');
        $this->load->library('infolojas');
        $this->load->helper('url');
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
                   $this->infolojas->CheckDadosLoja($Dados['o_loja'], $Dados['o_link']);
                   $this->DadosLoja = $this->infolojas->DadosLoja;
                   $this->ContatosSms = $this->infolojas->ContatosSms;
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
