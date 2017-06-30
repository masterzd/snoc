<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checklink extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->Model('Crud');
    }

    public function ConsultaOcorrenciaAB() {
        $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_status = 'Loja Offline'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        if ($this->Crud->Results['lines'] > 0):
            $this->Checklink($this->Crud->Results['Dados']);
        endif;
    }

    private function Checklink(array $Ocorrencias) {
        foreach ($Ocorrencias as $Ch):
            $Where = array('cir_loja' => $Ch['o_loja']);
            $this->Crud->calldb('tb_circuitos', 'SELECT', $Where);
            foreach ($this->Crud->Results['Dados'] as $Link):
                $TestePing = $this->Ping($Link['cir_ip_link']);
                $Result["{$Ch['o_cod']}"]["{$Link['cir_link']}"] = $TestePing;
            endforeach;
        endforeach;


        foreach ($Result as $Chamado => $Valor):
            $where = array('o_cod' => $Chamado);

            if (in_array('true', $Valor)):
                $Dados = array('o_status_temp' => 'Loja Online');
            else:
                $Count = array_count_values($Valor);
                if ($Count['false'] >= 1):
                    $Dados = array('o_status_temp' => 'Loja Offline');
                endif;
            endif;

            $this->Crud->calldb('tb_ocorrencias', 'UPDATE', $Dados, $where);
        endforeach;
    }

    private function Ping($IP) {
        exec("ping -w1 -i 0.2 -c 4 {$IP}", $output, $return_var);

        if (count($output)):
            $Saida = array_map('trim', $output);
            $ICMP1 = (preg_match('/Resposta/', $Saida[2]) ? true : (preg_match('/64 bytes/', $Saida[1]) ? true : false));
            $ICMP2 = (preg_match('/Resposta/', $Saida[3]) ? true : (preg_match('/64 bytes/', $Saida[2]) ? true : false));
            $ICMP3 = (preg_match('/Resposta/', $Saida[4]) ? true : (preg_match('/64 bytes/', $Saida[3]) ? true : false));
            $ICMP4 = (preg_match('/Resposta/', $Saida[4]) ? true : (preg_match('/64 bytes/', $Saida[4]) ? true : false));

            if ($ICMP1 == TRUE AND $ICMP2 == TRUE AND $ICMP3 == TRUE AND $ICMP4 == TRUE):
                return 'true';
            else:
                return 'false';
            endif;
        else:
            return false;
        endif;
    }

}
