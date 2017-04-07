<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Classe responsável pelas rotinas de atualização  da ocorrência
  Autor: Henrique Rocha
 *  */

class UpdateCh extends CI_Controller {

    private $Chamado;
    private $Loja;
    private $ContatosSms;
    private $DadosIn;
    private $Ultilitarios;

    function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['user'])):
            header('Location:' . base_url('Start/?erro=1'));
            return false;
        endif;
        require APPPATH . 'third_party/Ultilitario.php';
        $this->Ultilitarios = new Ultilitario();
        $this->load->library('sendsms');
        $this->load->library('email');
        $this->load->model('Crud');
        $this->load->helper('url');
    }

    /*     * *************************************************************************************************** */
    /*     * *************************************Metodo Principal********************************************** */
    /*     * *************************************************************************************************** */

    public function update() {
        $Ch = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Ch) and ! empty($Ch['o_cod']) and ! empty($_SESSION['Ocorrência_' . $Ch['o_cod']]['InfoCallViewCh'])):
            $this->Chamado = $_SESSION['Ocorrência_' . $Ch['o_cod']]['InfoCallViewCh']['DadosCh'];
            $this->Loja = $_SESSION['Ocorrência_' . $Ch['o_cod']]['InfoCallViewCh']['DadosLoja']['Loja'];
            $this->ContatosSms = $_SESSION['Ocorrência_' . $Ch['o_cod']]['InfoCallViewCh']['Contatos'];
            unset($_SESSION['Ocorrência_' . $Ch['o_cod']], $Ch['obs'], $Ch['o_cod']);
            $this->DadosIn = $Ch;

//            var_dump($this->Chamado);
//            var_dump($this->ContatosSms);
//            var_dump($this->DadosIn);
//            var_dump($this->Loja);



            switch ($this->Chamado['o_sit_ch']):
                case 2:
                   $Exe = $this->updateOperadora();
                    break;
                case 3:
                    $this->updateTecnico();
                    break;
                case 4:
                    $this->updateSemep();
                    break;
                case 6:
                 $Exe = $this->fechamentoOcorrencia();
                    break;
                case 7:
                    break;
                case 8:
                    break;

            endswitch;

            var_dump($Exe);


        else:
            if (empty($_SESSION)):
                session_start();
            endif;
            $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
            $Erro['Msg'] = "Não foram encontrados todos os dados necessários para processar sua solicitação. Por favor, Contate o suporte.";
            $this->load->view('errors/Erro', $Erro);
        endif;
    }

    /*     * *************************************************************************************************** */
    /*     * *************************************Metodos de Apoio********************************************** */
    /*     * *************************************************************************************************** */

    private function updateOperadora() {
        $this->DadosIn['o_sit_ch'] = 6;
        $this->DadosIn['o_last_update'] = date('Y-m-d H:i:s');
        $this->DadosIn['o_opr_op'] = $_SESSION['user']['Nome'];
        $Where = array('o_cod' => $this->Chamado['o_cod']);
        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $this->DadosIn, $Where);
        $Result = $this->Crud->Results;
        return $Result;
    }

    private function updateSemep() {
      
    }

    private function updateTecnico() {
        
    }

    private function updateInadiplencia() {
        
    }

    private function fechamentoOcorrencia() {        
        var_dump($this->DadosIn);
        
        if($this->DadosIn['sit'] == 1):
            unset($this->DadosIn['sit']);
            $this->DadosIn['o_sit_ch'] = 1;
            $this->DadosIn['o_cat_prob'] = $this->Ultilitarios->CatProblema($this->DadosIn['o_causa_prob']);
            $this->DadosIn['o_opr_fc'] = $_SESSION['user']['Nome'];
            $this->DadosIn['o_hr_fc'] = date('Y-m-d H:i:s');
            $this->DadosIn['o_last_update'] = date('Y-m-d H:i:s');
            $Where = array('o_cod' => $this->Chamado['o_cod']);
            $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $this->DadosIn, $Where);
            $this->Ultilitarios->TimeInds($this->Chamado['o_cod'], $this->DadosIn['o_hr_up'], $this->Chamado['o_hr_dw']);  
        endif;
        
        
        
        die();
        return $this->Crud->Results;
    }

    private function updateCancelamento() {
        
    }

    private function saveEventos($Ação) {
        $Eventos = array('e_nome' => $this->Chamado['o_opr_ab'], 'e_data' => date('Y-m-d H:i:s'), 'e_chamado' => $this->Chamado['o_cod'], 'e_acao' => $Ação);
        $this->Crud->calldb('tb_eventos', 'INSERT', $Eventos);
    }

    /* funcão faz envio de email */

    private function enviaEmail($Assunto, $Mensagem, $Dest) {
        /* Verifica se é permitido o envio de email */
        $this->Crud->calldb('tb_conf', 'SELECT', 0);
        if ($this->Crud->Results['Dados'][0]['c_sms'] == 'N'):
            return true;
        endif;

        $this->email->from('sisnoc2016@ricardoeletro.com.br', 'SISNOC');
        $this->email->to($Dest);
        $this->email->subject($Assunto);
        $this->email->message($Mensagem);
        return $this->email->send();
    }

    private function enviaSms() {
        
    }

}
