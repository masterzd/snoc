<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {

    private $Dados;
    private $Retorno;

    function __construct() {
        parent::__construct();
        $this->load->Model('Crud');
        $this->load->helper('url');
        require APPPATH . 'third_party/Ultilitario.php';
    }

    /* método responsável por fazer as consultas necessárias para Gerar o Relatório Geral */

    public function Geral() {
        $recDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($recDados) and ! empty($recDados['dataIni'])):
            $Util = new Ultilitario();
            $recDados['dataIni'] = $Util->DataUsa($recDados['dataIni']);
            $recDados['dataFim'] = $Util->DataUsa($recDados['dataFim']);
            $this->Dados = $recDados;



            /* Consultando os dados Gerais */

            /* Query para ver quantos chamados gerados durante o período informado */
            $QR1 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR1);
            $this->Retorno['Geral']['chGerPer'] = $this->Crud->Results['lines'];

            /* Query para checar quantos chamados abertos durante o período */
            $QR2 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch >= 2 AND o_sit_ch <= 7";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
            $this->Retorno['Geral']['chAbPer'] = $this->Crud->Results['lines'];

            /* Query para checar quantos chamados abertos causados pela operadora */
            $QR3 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_cat_prob = 'Operadora' ";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR3);
            $this->Retorno['Geral']['chAbOpPer'] = $this->Crud->Results['lines'];

            /* Query para checar quantos chamados abertos causados por problemas de Infra */
            $QR4 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_cat_prob = 'Infra-Estrutura' ";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR4);
            $this->Retorno['Geral']['chAbInfPer'] = $this->Crud->Results['lines'];

            /* Query para somar o tempo que que a loja ficou com o link indisponível */
            $QR5 = "SELECT sec_to_time(sum(time_to_sec(o_time_ind))) AS o_hora_total FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch = 1";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR5);
            $this->Retorno['Geral']['chTempoInd'] = $this->Crud->Results['Dados'][0]['o_hora_total'];

            /* Query para somar o tempo que o link ficou indisponível por causa de problemas com a operadora */
            $QR6 = "SELECT sec_to_time(sum(time_to_sec(o_time_ind))) AS o_hora_total FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch = 1 AND o_cat_prob ='Operadora'";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR6);
            $this->Retorno['Geral']['chTempoIndOPER'] = $this->Crud->Results['Dados'][0]['o_hora_total'];

            /* Query para somar o tempo que o link ficou indisponível por causa de problemas de infra-Estrutura */
            $QR7 = "SELECT sec_to_time(sum(time_to_sec(o_time_ind))) AS o_hora_total FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch = 1 AND o_cat_prob ='Infra-Estrutura'";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR7);
            $this->Retorno['Geral']['chTempoIndINFRA'] = $this->Crud->Results['Dados'][0]['o_hora_total'];

            /* Query para somar o tempo que o link ficou indisponível por causa de falta de energia */
            $QR8 = "SELECT sec_to_time(sum(time_to_sec(o_time_ind))) AS o_hora_total FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch = 1 AND o_cat_prob ='Elétrico'";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR8);
            $this->Retorno['Geral']['chTempoIndENER'] = $this->Crud->Results['Dados'][0]['o_hora_total'];


            /* Pesquisar ocorrências */

                /* Query para Filtrar os chamados por problema de Operadora e o status da loja  seja Loja Offline */
                $QR9 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch = 1 AND o_cat_prob ='Operadora' AND o_status = 'Loja Offline';";
                $this->Crud->calldb(0, 'SELECT', 0, 0, $QR9);
                $this->Retorno['Ocorrencias']['offOperadora'] = $this->Crud->Results['Dados'];
                
                /* Query para Filtrar os chamados por problema de operadora e o status da loja  seja funcionando pelo backup*/
                $QR10 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_cat_prob ='Operadora' AND (o_status = 'Funcionando ADSL' or o_status = 'Funcionando XDSL' or o_status = 'Funcionando 4G' or o_status = 'Funcionando IPConnect')";
                $this->Crud->calldb(0, 'SELECT', 0, 0, $QR10);
                $this->Retorno['Ocorrencias']['bkpOperadora'] = $this->Crud->Results['Dados'];
                
                /* Query para filtrar os chamados por problema de operadora e o status da loja seja funcionando pelo MPLS e a bandeira seja IN */
                $QR10 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_cat_prob ='Operadora' AND o_status = 'Funcionando MPLS'";
                $this->Crud->calldb(0, 'SELECT', 0, 0, $QR10);
                $this->Retorno['Ocorrencias']['funcPrin'] = $this->Crud->Results['Dados'];
                
                
            var_dump($this->Retorno);

        else:
            if (empty($_SESSION)):
                session_start();
            endif;
            $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
            $Erro['Msg'] = "Houve uma falha ao procurar os dados.";
            $this->load->view('errors/Erro', $Erro);
        endif;
        var_dump($recDados);
    }

}
