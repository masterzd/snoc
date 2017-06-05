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

            $Exe = NULL;

            switch ($this->Chamado['o_sit_ch']):
                case 2:
                    $Exe = $this->updateOperadora();
                    break;
                case 3:
                case 4:
                case 5:
                case 7:
                    $Exe = $this->Direcionar();
                    break;
                case 6:
                    $Exe = $this->fechamentoOcorrencia();
                    break;
            endswitch;
            if ($Exe == TRUE):
                
                if($this->Chamado['o_sit_ch'] == 2):
                    $SMS = $this->enviaSms(5);
                elseif ($this->DadosIn['sit'] == 1 and preg_match('/Cancelamento/', $this->DadosIn['o_causa_prob']) == 0):
                    $SMS = $this->enviaSms(2);
                elseif ($this->DadosIn['direcionar'] == 2):
                    $SMS = $this->enviaSms(3);
                elseif ($this->DadosIn['direcionar'] == 3):
                    /* Enviando Email */
//                    $Mensagem = "Caros Operadores:<br><br> A ocorrência {$this->Chamado['o_cod']} da loja {$this->Chamado['o_loja']} foi Atualizada pelo Técnico {$_SESSION['user']['Nome']}. Favor dar Continuidade a ocorrência.";
//                    $Assunto = "Atualização da ocorrência: {$this->Chamado['o_cod']}. Loja: {$this->Chamado['o_loja']}";
//                    $Destinatarios = $this->Ultilitarios->CheckDestinatários(3, $this->Loja['tr_cod']);
//                    $Email = $this->enviaEmail($Assunto, $Mensagem, $Destinatarios);
                    /* Envio SMS */
                    $SMS = $this->enviaSms(4);
                elseif ($this->DadosIn['direcionar'] == 4):
                    $SMS = $this->enviaSms(7);
                elseif($this->DadosIn['direcionar'] == 5):
                    $SMS = $this->enviaSms(6);
                else:
                    $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
                    $Erro['Msg'] = 'Consegui salvar o chamado. Mas não consegui determinar se envio SMS ou Email. Contate o suporte';
                    $this->load->view('errors/Erro', $Erro);
                    return false;
                endif;
                
            else:
                $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
                $Erro['Msg'] = 'Falha ao processar os dados ou a Hora que foi informada de normalização é menor que a hora que o link caiu. Verifique os dados e tente novamente.';
                $this->load->view('errors/Erro', $Erro);
                return false;
            endif;

            if (($this->Chamado['o_sit_ch'] != 3 and $SMS == TRUE) or ( !empty($Email) and $SMS == TRUE)):
                $Erro['Msg'] = "******* OK *********";
            elseif ($SMS == FALSE):
                $Erro['Msg'] = "Falha no Envio do SMS";
            else:
                $Erro['Msg'] = "Falha no Envio do Email";
            endif;

            $Erro['Sucess'] = "Ocorrência salva com sucesso!!";
            $this->load->view('errors/Erro', $Erro);
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
        if(!empty($this->DadosIn['link_prev']) and $this->DadosIn['link_prev'] == 'on'):
            $action = array('o_cod' => $this->Chamado['o_cod'], 'ch_acao' => 'Preventiva Aberta - Operadora');
            $this->Crud->calldb('tb_ch_acao', 'INSERT', $action);
            unset($this->DadosIn['link_prev']);
        endif;
        
        if(!empty($this->DadosIn['link_norm'])):
           unset($this->DadosIn['link_norm']);
        endif;
        
        
        $this->DadosIn['o_sit_ch'] = 6;
        $this->DadosIn['o_last_update'] = date('Y-m-d H:i:s');
        $this->DadosIn['o_opr_op'] = $_SESSION['user']['Nome'];
        $Where = array('o_cod' => $this->Chamado['o_cod']);
        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $this->DadosIn, $Where);
        $Result = $this->Crud->Results;
        $this->saveEventos('Alterou');
        
        
        
        return $Result;
    }

    private function Direcionar() {

        if (!empty($this->DadosIn['direcionar'])):

            switch ($this->DadosIn['direcionar']):
                case 2:
                    $this->DadosIn['o_sit_ch'] = 2;
                    $this->DadosIn['o_nece'] = 2;
                    break;
                case 3:
                    $this->DadosIn['o_sit_ch'] = 3;
                    $this->DadosIn['o_nece'] = 3;
                    break;
                case 4:
                    $this->DadosIn['o_sit_ch'] = 4;
                    $this->DadosIn['o_nece'] = 4;
                    break;
                case 5:
                    $this->DadosIn['o_nece'] = 5;
                    break;
                case 7:
                    $this->DadosIn['o_nece'] = 7;
                    break;
            endswitch;

        elseif ($this->DadosIn['sit'] == 1):
            $this->DadosIn['o_sit_ch'] = 6;
            $this->DadosIn['o_opr_op'] = $_SESSION['user']['Nome'];
        else:
            return true;
        endif;

        $Ocorrência = $this->DadosIn;
        unset($Ocorrência['sit']);

        if (!empty($Ocorrência['direcionar'])):
            unset($Ocorrência['direcionar']);
        endif;

        $this->DadosIn['o_last_update'] = date('Y-m-d H:i:s');
        $Where = array('o_cod' => $this->Chamado['o_cod']);
        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Ocorrência, $Where);
        $this->saveEventos('Alterou');
        return $this->Crud->Results;
    }

    private function fechamentoOcorrencia() {

        if ($this->DadosIn['sit'] == 1):

            $HrUP = $this->Ultilitarios->ConvSeg($this->DadosIn['o_hr_up']);
            $HrDown = $this->Ultilitarios->ConvSeg($this->Chamado['o_hr_dw']);

            if ($HrUP < $HrDown):
                return false;
            endif;
            $Ocorrencia = $this->DadosIn;
            unset($Ocorrencia['sit']);
            $Ocorrencia['o_sit_ch'] = (preg_match('/Cancelamento/', $this->DadosIn['o_causa_prob']) ? 8 : 1 );
            $Ocorrencia['o_cat_prob'] = $this->Ultilitarios->CatProblema($this->DadosIn['o_causa_prob']);
            $Ocorrencia['o_opr_fc'] = $_SESSION['user']['Nome'];
            $Ocorrencia['o_hr_fc'] = date('Y-m-d H:i:s');
            $Ocorrencia['o_last_update'] = date('Y-m-d H:i:s');
            $Where = array('o_cod' => $this->Chamado['o_cod']);
            $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Ocorrencia, $Where);
            $this->Ultilitarios->TimeInds($this->Chamado['o_cod'], $Ocorrencia['o_hr_up'], $this->Chamado['o_hr_dw']);
            $this->saveEventos('Fechou');
            $Exe = $this->Crud->Results;
        elseif ($this->DadosIn['sit'] == 2):
            $Exe = $this->Direcionar();
        endif;

        return $Exe;
    }

    private function saveEventos($Ação) {
        $Eventos = array('e_nome' => $_SESSION['user']['Nome'], 'e_data' => date('Y-m-d H:i:s'), 'e_chamado' => $this->Chamado['o_cod'], 'e_acao' => $Ação);
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

    private function enviaSms($Etapa) {
        return $this->sendsms->sms($this->ContatosSms, $this->Chamado, $this->Loja, $Etapa);
    }

}
