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
            $QR2 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_link = 'MPLS'";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
            $this->Retorno['Geral']['chGerMPLS'] = $this->Crud->Results['lines'];

            /* Query para checar quantos chamados abertos causados pela operadora */
            $QR3 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_link NOT LIKE 'MPLS' ";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR3);
            $this->Retorno['Geral']['chAGerBK'] = $this->Crud->Results['lines'];

            /* Pesquisar ocorrências */

            switch ($this->Dados['sit-ch']):
                case '1':
                    $QR4 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 7;";
                    break;
                case '2':
                    $QR4 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch = 1";
                    break;
                case '3':
                    $QR4 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'";
                    break;
                default:
                    $MS = "Não consegui entender qual a situação da ocorrência";
                    $this->Erro($MS);
                    return;
                    break;
            endswitch;

            /* Query para Filtrar os chamados por problema de Operadora e o status da loja  seja Loja Offline */

            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR4);
            $this->Retorno['Ocorrencias']['offOperadora'] = $this->Crud->Results['Dados'];
            $this->Retorno['Periodo'] = $this->Dados;
            $this->load->view('relatorios/relGeral', $this->Retorno);
        else:
            $MS = "Houve uma falha ao procurar os dados.";
            $this->Erro($MS);
            return;
        endif;
    }

    public function relSMS() {
        $recDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($recDados) and ! empty($recDados['dataIni'])):
            $Util = new Ultilitario();
            $recDados['dataIni'] = $Util->DataUsa($recDados['dataIni']);
            $recDados['dataFim'] = $Util->DataUsa($recDados['dataFim']);
            $this->Dados = $recDados;

            /* Busca de Informações dos SMS por data ou data e loja */
            if (!empty($this->Dados['lj_num'])):
                $QR1 = "SELECT * FROM tb_sms WHERE sms_date BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND sms_loja = {$this->Dados['lj_num']}";
                $QR2 = "SELECT * FROM tb_sms WHERE sms_sit_env NOT LIKE '000' AND sms_date BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND sms_loja = {$this->Dados['lj_num']}";
                $QR3 = "SELECT * FROM tb_sms WHERE sms_sit_env = '000' AND sms_date BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND sms_loja = {$this->Dados['lj_num']}";
            else:
                $QR1 = "SELECT * FROM tb_sms WHERE sms_date BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'";
                $QR2 = "SELECT * FROM tb_sms WHERE sms_sit_env NOT LIKE '000' AND sms_date BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'";
                $QR3 = "SELECT * FROM tb_sms WHERE sms_sit_env = '000' AND sms_date BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'";
            endif;
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR1);

            if ($this->Crud->Results == NULL):
                $MS = "Não encontrei os dados para exibir. Verifique os dados e tente novamente.";
                $this->Erro($MS);
                return;
            else:
                /* Consulta para verificar quantos SMS foram enviados durante o período */
                $this->Retorno['envFull'] = $this->Crud->Results['lines'];
                $this->Retorno['Dados'] = $this->Crud->Results['Dados'];
                $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
                $this->Retorno['envFalse'] = $this->Crud->Results['lines'];
                $this->Crud->calldb(0, 'SELECT', 0, 0, $QR3);
                $this->Retorno['envSucess'] = $this->Crud->Results['lines'];
                $this->Retorno['Periodo'] = $this->Dados;
                $this->load->view('relatorios/relSms', $this->Retorno);
            endif;

        else:
            $MS = "Houve uma falha ao procurar os dados.";
            $this->Erro($MS);
            return;
        endif;
    }

    public function relLoja() {

        $recDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($recDados) and ! empty($recDados['dataIni'])):
            $Util = new Ultilitario();
            $recDados['dataIni'] = $Util->DataUsa($recDados['dataIni']);
            $recDados['dataFim'] = $Util->DataUsa($recDados['dataFim']);
            $this->Dados = $recDados;

            switch ($this->Dados['sit-ch']):
                case '1':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8";
                    break;
                case '2':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'AND o_sit_ch = 1";
                    break;
                case '3':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59'";
                    break;
                default :
                    $MS = "Não consegui entender o status da ocorrência. Verifique os dados e tente novamente";
                    $this->Erro($MS);
                    return;
                    break;
            endswitch;
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);

            if ($this->Crud->Results == NULL):
                $MS = "Não encontrei os dados para exibir. Verifique os dados e tente novamente.";
                $this->Erro($MS);
            else:
                $this->Retorno['Resultados'] = $this->Crud->Results['Dados'];
                $this->Retorno['Periodo'] = $this->Dados;
                $this->load->view('relatorios/relLoja', $this->Retorno);
            endif;

        else:
            $MS = "Houve uma falha ao procurar os dados.";
            $this->Erro($MS);
            return;
        endif;
    }

    public function relDispInter() {
        $recDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($recDados) and ! empty($recDados['dataIni'])):

            $Util = new Ultilitario();
            $recDados['dataIni'] = $Util->DataUsa($recDados['dataIni']);
            $recDados['dataFim'] = $Util->DataUsa($recDados['dataFim']);
            $this->Dados = $recDados;

            $QR = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '{$this->Dados['dataIni']} 00:00:00' AND '{$this->Dados['dataFim']} 23:59:59' AND o_sit_ch NOT LIKE 7";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
            if ($this->Crud->Results == NULL):
                $MS = "Não encontrei os dados para exibir. Verifique os informações e tente novamente.";
                $this->Erro($MS);
                return;
            endif;

            $this->Retorno['Periodo'] = $this->Dados;
            $this->Retorno['Resultado'] = $this->Crud->Results['Dados'];
            $this->load->view('relatorios/relDisp', $this->Retorno);
        else:
            $MS = "Houve uma falha ao consultar os dados";
            $this->Erro($MS);
            return;
        endif;
    }

    private function Erro($Messagem) {
        if (empty($_SESSION)):
            session_start();
        endif;
        $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
        $Erro['Msg'] = $Messagem;
        $this->load->view('errors/Erro', $Erro);
        return;
    }

}
