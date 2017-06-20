<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ocorrencia extends CI_Controller {

    private $Chamado;
    private $Loja;
    private $ContatosSms;
    private $TpAc;
    private $Notas;

    function __construct() {
        parent::__construct();
        $this->load->library('infolojas');
        $this->load->helper('url');
        $this->load->model('Crud');
    }

    public function ConsultaCh() {
        $Ch = (int) $this->input->get('Ch');
        if ($Ch == NULL):
            die('Parametro inválido');
        endif;

        /* Pesquisando Ocorrência */
        $this->SearchOcorrencia($Ch);
        if ($this->Chamado != NULL):
            $this->SearchLoja();
            $this->CallView();
        else:
            $this->Fail();
        endif;
    }

    private function SearchOcorrencia($Ch) {
        /* Consultando ocorrência */
        $Chamado = array('o_cod' => $Ch);
        $this->Crud->calldb('tb_ocorrencias', 'SELECT', $Chamado);
        $this->Chamado = $this->Crud->Results['Dados'][0];

        /* Consultando Tipo de Problema e ação tomada */
        $this->Crud->calldb('tb_ch_acao', 'SELECT', $Chamado);
        $this->TpAc['acao'] = $this->Crud->Results['Dados'];

        /* Consultando tipo de problema */
        $this->Crud->calldb('tb_ch_prob', 'SELECT', $Chamado);
        $this->TpAc['prob'] = $this->Crud->Results['Dados'];

        /* Consulta notas da ocorrência */
        $Qr = "SELECT * FROM tb_ch_notas WHERE o_cod = {$Chamado['o_cod']} ORDER BY ch_time DESC";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $Qr);
        $this->Notas = $this->Crud->Results['Dados'];
    }

    private function SearchLoja() {
        $this->infolojas->CheckDadosLoja($this->Chamado['o_loja'], $this->Chamado['o_link']);
        $this->Loja = $this->infolojas->DadosLoja;
        $this->ContatosSms = $this->infolojas->ContatosSms;
    }

    private function Fail() {
        if (empty($_SESSION)):
            session_start();
        endif;
        $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
        $Erro['Msg'] = "A Ocorrência informada não foi encontrada.";
        $this->load->view('errors/Erro', $Erro);
    }

    private function CallView() {
        session_start();

        $_SESSION['Ocorrência_' . $this->Chamado['o_cod']]['InfoCallViewCh'] = [
            'DadosCh' => $this->Chamado,
            'DadosLoja' => $this->Loja,
            'Contatos' => $this->ContatosSms,
            'Notas' => $this->Notas,
            'TPAC' => $this->TpAc
        ];

        $this->load->view('ocorrencia', $_SESSION['Ocorrência_' . $this->Chamado['o_cod']]);
    }
}
