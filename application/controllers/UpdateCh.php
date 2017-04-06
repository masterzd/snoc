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
        if (!empty($Ch) and !empty($Ch['o_cod']) and !empty($_SESSION['Ocorrência_'.$Ch['o_cod']]['InfoCallViewCh'])):
            $this->Chamado = $_SESSION['Ocorrência_'.$Ch['o_cod']]['InfoCallViewCh']['DadosCh'];
            $this->Loja = $_SESSION['Ocorrência_'.$Ch['o_cod']]['InfoCallViewCh']['DadosLoja']['Loja'];
            $this->ContatosSms = $_SESSION['Ocorrência_'.$Ch['o_cod']]['InfoCallViewCh']['Contatos'];
            unset($_SESSION['Ocorrência_'.$Ch['o_cod']],$Ch['obs'], $Ch['o_cod']);
            $this->DadosIn = $Ch;
            
            var_dump($this->Chamado);
            var_dump($this->ContatosSms);
            var_dump($this->DadosIn);
            var_dump($this->Loja);
            
            if(!empty($this->DadosIn['sit'])):
                  
               else: 
                 
            endif;
            
            
            
            
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
        
        
        
        
    }

    private function updateSemep() {
        
    }

    private function updateTecnico() {
        
    }

    private function updateInadiplencia() {
        
    }

    private function fechamentoOcorrencia() {
        
    }

    private function updateCancelamento() {
        
    }

    private function enviaEmail() {
        
    }

    private function enviaSms() {
        
    }

}
