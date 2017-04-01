<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ultilitario extends CI_Controller {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->Model('Crud');
        require APPPATH.'third_party/funcao.php';
    }

    public function DataBR($Data) {
        $termo = "T";
        if (strstr($Data, $termo) == TRUE):
            $quebradata = explode('T', $Data);
            $Data2 = explode("-", $quebradata[0]);
            $DataBR = "{$Data2[2]}/{$Data2[1]}/{$Data2[0]} as {$quebradata[1]}";
        else:

            $quebradata = explode(' ', $Data);
            $Data2 = explode("-", $quebradata[0]);

            if (!empty($Data2[0])):
                $DataBR = "{$Data2[2]}/{$Data2[1]}/{$Data2[0]}  {$quebradata[1]}";
            endif;

        endif;

        if (empty($DataBR)):
            $DataBR = "Sem Informações";
            return $DataBR;
        else:
            return $DataBR;
        endif;
    }

    public function CheckDestinatários($Enc, $TecCod = NULL) {

//        $Destinatarios = [
//            'Sup. Noc' => 'jorge.zenha@ricardoeletro.com.br',
//            'Res. Ope1' => 'edson.neves@ricardoeletro.com.br',
//            'Res. Ope2' => 'orlando.santos@ricardoeletro.com.br',
//            'Noc' => 'operadorti@ricardoeletro.com.br'
//        ];
        $Destinatarios = [
            'Sup. Noc' => 'henrique.souza@ricardoeletro.com.br',
            'Res. Ope1' => 'henrique.souza@ricardoeletro.com.br',
            'Res. Ope2' => 'henrique.souza@ricardoeletro.com.br',
            'Noc' => 'henrique.souza@ricardoeletro.com.br'
        ];

        if ($Enc == 2):
            $D = array($Destinatarios['Sup. Noc'], $Destinatarios['Res. Ope1'], $Destinatarios['Res. Ope2']);
        elseif ($Enc == 3):
            $Resp = array('resp_cod' => $TecCod);
            $this->CI->Crud->calldb('tb_resp_tec', 'SELECT', $Resp);
            $D = array($this->CI->Crud->Results['Dados'][0]['resp_email'], $Destinatarios['Sup. Noc']);
        elseif ($Enc == 4):
            $D = array($Destinatarios['Sup. Noc']);
        elseif ($Enc == 5):
            $D = array($Destinatarios['Sup. Noc'], $Destinatarios['Noc']);
        endif;

        return $D;
    }

    public function prazoFaltadeEnergia() {
        $time = new DateTime(date("Y-m-d H:i:s"));
        $time->add(new DateInterval("PT2H"));
        $Prazo = (array) $time;
        return $Prazo['date'];
    }

    public function prazoTecnico() {
        $time = new DateTime(date("Y-m-d H:i:s"));
        $time->add(new DateInterval("P2D"));
        $Prazo = (array) $time;
        return $Prazo['date'];
    }

    public function CatProblema($Problema) {
        /* Checando a categoria do problema */
        if ($Problema == 'INT_Cancelamento' or $Problema == "OP_Cancelamento"):
            $Cat = "Abertura Indevida";
        elseif (preg_match('/INT_/', $Problema)):
            $Cat = "Infra-Estrutura";
        elseif (preg_match('/OP_/', $Problema)):
            $Cat = "Operadora";
        elseif (preg_match('/CO_/', $Problema)):
            $Cat = "Concessionária";
        elseif (preg_match('/IMP_/', $Problema)):
            $Cat = "Improdutividade";
        endif;

        return $Cat;
    }

    public function TimeInds($NumCh, $HrUP, $HrDW) {        
        $T = array('b');
        $D = array('ok');
        $QR = "SELECT TIMEDIFF(o_hr_up, tb_ocorrencias.o_hr_dw)o_difftime, o_cod, o_hr_dw, o_hr_up FROM tb_ocorrencias WHERE o_cod LIKE {$NumCh}";
        $this->CI->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $difftime = $this->CI->Crud->Results['Dados'][0]['o_difftime']; 
        $this->Worktime($NumCh ,$HrUP, $HrDW, $difftime);
    }
    
    private function Worktime($NumCh ,$HrUP, $HrDW, $DIF){
        $worktime = calc_data($HrUP, $HrDW, $DIF);
        $where = array('o_cod' => $NumCh);
        $Time = array('o_time_ind' => $DIF, 'o_time_work' => $worktime);
        $this->CI->Crud->calldb('tb_ocorrencias', 'UPDATE', $Time, $where);
    }

}
