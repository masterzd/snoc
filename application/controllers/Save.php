<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Classe responsável pelas rotinas de Gravação da ocorrência
  Autor: Henrique Rocha
 *  */

class Save extends CI_Controller {

    private $Chamado;
    private $Contatos;
    private $DadosLoja;

    function __construct() {
        parent::__construct();
        session_start();
        require APPPATH . 'third_party/Ultilitarios.php';
        $this->load->library('sendsms');
        $this->load->library('email');
        $this->load->model('Crud');
        $this->load->helper('url');
    }

    public function SaveCh() {

        $DadosCh = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($DadosCh) and ! empty($DadosCh['tp_desc'])):
            $this->Chamado = $DadosCh;
            $this->Chamado = array_merge($this->Chamado, $_SESSION['InfoCallViewCh']['DadosCh']);
            $this->DadosLoja = $_SESSION['InfoCallViewCh']['DadosLoja'];
            $this->Contatos = $_SESSION['InfoCallViewCh']['Contatos'];
            $Check = $this->verificaDados();
            
            $Resp = $this->eletrica();
            var_dump($Resp);

        endif;
    }

    /* Funcão criada para verificar a corencia dos dados */
    private function verificaDados() {

        if ($this->Chamado['o_link'] == 'MPLS' and $this->Chamado['tp_desc'][0] == 'Link Inoperante' and $this->Chamado['o_status'] == 'Funcionando_MPLS'):
            $Link = $this->Chamado['o_link'];
        elseif ($this->Chamado['o_link'] == 'ADSL' and $this->Chamado['tp_desc'][0] == 'Link Inoperante' and $this->Chamado['o_status'] == 'Funcionando_ADSL'):
            $Link = $this->Chamado['o_link'];
        elseif ($this->Chamado['o_link'] == 'XDSL' and $this->Chamado['tp_desc'][0] == 'Link Inoperante' and $this->Chamado['o_status'] == 'Funcionando_XDSL'):
            $Link = $this->Chamado['o_link'];
        elseif ($this->Chamado['o_link'] == 'IPConnect' and $this->Chamado['tp_desc'][0] == 'Link Inoperante' and $this->Chamado['o_status'] == 'Funcionando_IPConnect'):
            $Link = $this->Chamado['o_link'];
        elseif ($this->Chamado['o_link'] == 'Lan2Lan' and $this->Chamado['tp_desc'][0] == 'Link Inoperante' and $this->Chamado['o_status'] == 'Funcionando_Lan2Lan'):
            $Link = $this->Chamado['o_link'];
        endif;

        if (!empty($Link)):
            $Messagem = "Falha ao abrir a ocorrência: Você não pode abrir uma ocorrência para um link `{$Link}, informando que está inoperante e dizer que está funcionando pelo {$Link}";
            return $Messagem;
        else:
            return false;
        endif;
    }

    /* Função que possui as rotinas quando a ocorrência é direcionada para a operadora */
    private function operadora() {
        
        $Arr['o_last_update'] = date('Y-m-d H:i:s');
        $Arr['o_sit_ch'] = 2;
        $Arr['o_op'] = $this->DadosLoja['Link']['cir_oper'];
        $Arr['o_nece'] = 2;
        $Where['o_cod'] = $this->Chamado['o_cod'];

        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Arr, $Where);
        if ($this->Crud->Results == false):
            $Messagem = "Falha ao salvar a ocorrência: Erro na atualização dos dados. Contate o suporte para verificar os dados";
            return $Messagem;
        endif;
        /* Salvando notas da ocorrência */
        $Notas = $this->saveNotas();

        /* Salvando Tipo de problema e ação tomada */
        $this->saveTpAc();

        /* Savando na Tabela de Eventos */
        $this->saveEventos();

        /* Envio de Email */
        /* Assunto */
        $Assunto = "Link Alarmado - Loja: {$this->Chamado['o_loja']}. Ocorrência SISNOC: {$this->Chamado['o_cod']}";
        /* Mensagem */
        $Mensagem = "Caro Residente. Segue ocorrência SisNOC aberta pelos operadores. Número da Ocorrência: {$this->Chamado['o_cod']}. Favor realizar a abertura do chamado na operadora.";
        /* Destinatários */
        $Dest = CheckDestinatários(2);
        /* Enviando Email */
        $sendEmail = $this->enviaEmail($Assunto, $Mensagem, $Dest);

        /* Enviando SMS */
        $SMS = $this->sendsms->sms($this->Contatos, $this->Chamado, $this->DadosLoja, 3);

        if ($sendEmail == true and $SMS == true):
            return true;
        elseif ($sendEmail == false):
            return "Email";
        elseif ($SMS == false):
            return "sms";
        endif;
    }

    /* Função que possui as rotinas quando a ocorrência é direcionada para SEMEP */

    private function infra() {
                
        $Arr['o_last_update'] = date('Y-m-d H:i:s');
        $Arr['o_sit_ch'] = 4;
        $Arr['o_op'] = $this->DadosLoja['Link']['cir_oper'];
        $Arr['o_nece'] = 4;
        $Arr['o_prazo'] = prazoFaltadeEnergia();
        $Arr['o_sisman'] = $this->Chamado['o_sisman'];
        $Where['o_cod'] = $this->Chamado['o_cod'];

        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Arr, $Where);
        if ($this->Crud->Results == false):
            $Messagem = "Falha ao salvar a ocorrência: Erro na atualização dos dados. Contate o suporte para verificar os dados";
            return $Messagem;
        endif;

        /* Salvando notas da ocorrência */
        $Notas = $this->saveNotas();

        /* Salvando Tipo de problema e ação tomada */
        $this->saveTpAc();

        /* Savando na Tabela de Eventos */
        $this->saveEventos();

        /* Envio de Email */
        /* Assunto */
        $Assunto = "Link Alarmado - Loja: {$this->Chamado['o_loja']}. Ocorrência SISNOC: {$this->Chamado['o_cod']}";
        /* Mensagem */
        $Mensagem = "Caro Gestor. A loja {$this->Chamado['o_loja']} está com problema de infra-estrutura interna . Chamado SISMAN: {$this->Chamado['o_sisman']}  Ocorrência SISNOC: {$this->Chamado['o_cod']}.";
        /* Destinatários */
        $Dest = CheckDestinatários(4);
        /* Enviando Email */
        $sendEmail = $this->enviaEmail($Assunto, $Mensagem, $Dest);

        /* Enviando SMS */
        $SMS = $this->sendsms->sms($this->Contatos, $this->Chamado, $this->DadosLoja, 7);

        if ($sendEmail == true and $SMS == true):
            return true;
        elseif ($sendEmail == false):
            return "Email";
        elseif ($SMS == false):
            return "sms";
        endif;
    }

    /* Função que possui as rotinas quando a  ocorrencia é direcionada falta de energia */
    private function eletrica() {
        
        $Arr['o_last_update'] = date('Y-m-d H:i:s');
        $Arr['o_sit_ch'] = 6;
        $Arr['o_op'] = $this->DadosLoja['Link']['cir_oper'];
        $Arr['o_nece'] = 5;
        $Arr['o_prazo'] = prazoFaltadeEnergia();
        $Where['o_cod'] = $this->Chamado['o_cod'];

        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Arr, $Where);
        if ($this->Crud->Results == false):
            $Messagem = "Falha ao salvar a ocorrência: Erro na atualização dos dados. Contate o suporte para verificar os dados";
            return $Messagem;
        endif;
        
        /* Salvando notas da ocorrência */
        $Notas = $this->saveNotas();

        /* Salvando Tipo de problema e ação tomada */
        $this->saveTpAc();

        /* Savando na Tabela de Eventos */
        $this->saveEventos();
        
        /* Envio de Email */
            /* Assunto */
            $Assunto = "Link Alarmado - Loja: {$this->Chamado['o_loja']}. Ocorrência SISNOC: {$this->Chamado['o_cod']}";
            /* Mensagem */
            $Mensagem = "Caro Gestor. A loja {$this->Chamado['o_loja']} está sem energia . Ocorrência SISNOC: {$this->Chamado['o_cod']}.";
            /* Destinatários */
            $Dest = CheckDestinatários(4);
            /* Enviando Email */
            $sendEmail = $this->enviaEmail($Assunto, $Mensagem, $Dest);

        /* Enviando SMS */
        $SMS = $this->sendsms->sms($this->Contatos, $this->Chamado, $this->DadosLoja, 6);

        if ($sendEmail == true and $SMS == true):
            return true;
        elseif ($sendEmail == false):
            return "Email";
        elseif ($SMS == false):
            return "sms";
        endif;
        
    }

    /* função que possui as rotinas quando a ocorrencia é direcionada para o técnico */
    private function tecnico() {
        
        $Arr['o_last_update'] = date('Y-m-d H:i:s');
        $Arr['o_sit_ch'] = 3;
        $Arr['o_op'] = $this->DadosLoja['Link']['cir_oper'];
        $Arr['o_nece'] = 3;
        $Arr['o_otrs'] = $this->Chamado['o_otrs'];
        $Arr['o_prazo'] = prazoTecnico();
        $Where['o_cod'] = $this->Chamado['o_cod'];

        $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Arr, $Where);
        if ($this->Crud->Results == false):
            $Messagem = "Falha ao salvar a ocorrência: Erro na atualização dos dados. Contate o suporte para verificar os dados";
            return $Messagem;
        endif;
        
         /* Salvando notas da ocorrência */
        $Notas = $this->saveNotas();

        /* Salvando Tipo de problema e ação tomada */
        $this->saveTpAc();

        /* Savando na Tabela de Eventos */
        $this->saveEventos();
        
        /* Envio de Email */
            /* Assunto */
            $Assunto = "Link Alarmado - Loja: {$this->Chamado['o_loja']}. Ocorrência SISNOC: {$this->Chamado['o_cod']}";
            /* Mensagem */
            $Mensagem = "Caros Gestores. A loja {$this->Chamado['o_loja']} está necessitando a presença de um técnico. Chamado OTRS: {$this->Chamado['o_otrs']}  Ocorrência SISNOC: {$this->Chamado['o_cod']}.";
            /* Destinatários */
            $Dest = CheckDestinatários(3, $this->DadosLoja['Loja']['tr_cod']);
            /* Enviando Email */
            $sendEmail = $this->enviaEmail($Assunto, $Mensagem, $Dest);

        /* Enviando SMS */
        $SMS = $this->sendsms->sms($this->Contatos, $this->Chamado, $this->DadosLoja, 4);

        if ($sendEmail == true and $SMS == true):
            return true;
        elseif ($sendEmail == false):
            return "Email";
        elseif ($SMS == false):
            return "sms";
        endif;
        
    }


    /* Função com as rotinas para salvar a nota da ocorrência */
    private function saveNotas() {
        $Nota = array('ch_nota' => $this->Chamado['obs'], 'ch_user' => $this->Chamado['o_opr_ab'], 'o_cod' => $this->Chamado['o_cod'], 'ch_time' => date('Y-m-d H:i:s'));
        $this->Crud->calldb('tb_ch_notas', 'INSERT', $Nota);

        if ($this->Crud->Results == false):
            $Messagem = "Falha ao salvar a ocorrência: Erro ao inserir a nota. Contate o suporte";
            return $Messagem;
        else:
            return true;
        endif;
    }

    private function saveTpAc() {

        /* Tipo de problema */
        foreach ($this->Chamado['tp_desc'] as $TP):
            $tipoProb = array('o_cod' => $this->Chamado['o_cod'], 'ch_prob' => $TP);
            $this->Crud->calldb('tb_ch_prob', 'INSERT', $tipoProb);
        endforeach;

        /* Ação tomada */
        foreach ($this->Chamado['ac_desc'] as $AC):
            $acaoTomada = array('o_cod' => $this->Chamado['o_cod'], 'ch_acao' => $AC);
            $this->Crud->calldb('tb_ch_acao', 'INSERT', $acaoTomada);
        endforeach;
    }

    private function saveEventos() {
        $Eventos = array('e_nome' => $this->Chamado['o_opr_ab'], 'e_data' => date('Y-m-d H:i:s'), 'e_chamado' => $this->Chamado['o_cod'], 'e_acao' => 'Abriu');
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


}
