<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DashBoard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud');
        $this->load->helper('url');
        require APPPATH . 'third_party/Ultilitario.php';
    }

    public function Inicio() {
        $this->load->view('dashboard');
    }
    
    /* Função que é responsável por gerar os dados que são apresentados na tela Home do dashboard */
    public function Home() {


        $QR1 = "SELECT lj_num from tb_lojas WHERE lj_sit NOT LIKE 'Fechada'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR1);
        $lojasCad = $this->Crud->Results['lines'] ?? 0;

        $QR2 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'MPLS' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
        $MPLS = $this->Crud->Results['lines'] ?? 0;

        $QR3 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'ADSL' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR3);
        $ADSL = $this->Crud->Results['lines'] ?? 0;

        $QR4 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'XDSL' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR4);
        $XDSL = $this->Crud->Results['lines'] ?? 0;

        $QR5 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'IPConnect' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR5);
        $IpCon = $this->Crud->Results['lines'] ?? 0;

        $QR6 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = '4G' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR6);
        $mb4g = $this->Crud->Results['lines'] ?? 0;

        $QR7 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'Radio' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR7);
        $radio = $this->Crud->Results['lines'] ?? 0;

        $QR = "SELECT DISTINCT o_loja,(SELECT COUNT(*) FROM tb_ocorrencias WHERE o_loja = tb.o_loja AND o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 7) as Chamados FROM tb_ocorrencias as tb WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 7";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $Inc = $this->Crud->Results['lines'] ?? 0;
        $IncArr = $this->Crud->Results['Dados'];


        $Dados = [
            'MPLS' => $MPLS,
            'ADSL' => $ADSL,
            'XDSL' => $XDSL,
            'IPCon' => $IpCon,
            'MB4G' => $mb4g,
            'Radio' => $radio,
            'LjInc' => $Inc,
            'CadLj' => $lojasCad,
            'LjIncArr' => $IncArr
        ];


        $this->load->view('dashboard/home', $Dados);
    }

    public function periodoTopLojas() {

        $Per = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Per) and ! empty($Per['per'])):

            $Data = $this->getPeriodo($Per['per']);
            $QR = "select distinct o_loja,(select count(*) from tb_ocorrencias where o_loja = ch.o_loja and o_hr_ch between '{$Data[0]} 00:00:00' and '{$Data[1]} 23:59:59') as count from tb_ocorrencias as ch where o_hr_ch between '{$Data[0]} 00:00:00' and '{$Data[1]} 23:59:59' order by count DESC LIMIT 10";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);

            if ($this->Crud->Results['lines'] >= 1):
                echo json_encode($this->Crud->Results['Dados']);
            else:
                echo 'false';
            endif;
        else:
            echo "false";

        endif;
    }

    public function getOcorrenciasChart() {

        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Dados) and ! empty($Dados['o_loja'])):
            $Util = new Ultilitario();

            $Data = $this->getPeriodo($Dados['per']);

            $QR = "SELECT * FROM tb_ocorrencias WHERE o_loja = {$Dados['o_loja']} AND o_hr_ch BETWEEN '{$Data[0]} 00:00:00' AND '{$Data[1]} 23:59:59'";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);

            echo "
                <div class=\"table-responsive\">
                    <table class=\"table table-striped\">
                                <thead class=\"table-custom\">
                                    <tr class=\"tb-color\">
                                        <th class=\"hidden-table\">Num. Ocor.</th>
                                        <th>Situação</th>
                                        <th>Aberto em:</th>
                                        <th>Hora do Incidente</th>
                                        <th>Causa do Problema</th>
                                        <th>Fechado em:</th>                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    ";

            foreach ($this->Crud->Results['Dados'] as $Ch):

                $Sit = ($Ch['o_sit_ch'] == 1 ? 'Fechado' : ($Ch['o_sit_ch'] == 8 ? 'Cancelado' : 'Aberto'));
                $Ch['o_hr_ch'] = $Util->DataBR($Ch['o_hr_ch']);
                $Ch['o_hr_fc'] = $Util->DataBR($Ch['o_hr_fc']);
                $Ch['o_hr_dw'] = $Util->DataBR($Ch['o_hr_dw']);
                echo "  <tr>
                            <td>{$Ch['o_cod']}</td>
                            <td>{$Sit}</td>
                            <td>{$Ch['o_hr_ch']}</td>
                            <td>{$Ch['o_hr_dw']}</td>
                            <td>{$Ch['o_causa_prob']}</td>
                            <td>{$Ch['o_hr_fc']}</td>
                        </tr> ";
            endforeach;
        echo "
                </tbody>
            </table>
         </div>";

        endif;
    }
    
    
    public function operadora(){
        
        $Info = $this->getDadosChamadosOperadora(true);
        
        $this->load->view('dashboard/operadora', $Info);
    }
    
    public function getDadosChamadosOperadora($Return = false){
        
        /* Verifica quantas ocorrências de cada link existe em aberto direcionado para a operadora */
        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'MPLS'";
        $this->Crud->calldb(0,'SELECT', 0,0,$QR);
        $MPLS = $this->Crud->Results;
        
        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'ADSL'";
        $this->Crud->calldb(0,'SELECT', 0,0,$QR);
        $ADSL = $this->Crud->Results;

        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'XDSL'";
        $this->Crud->calldb(0,'SELECT', 0,0,$QR);
        $XDSL = $this->Crud->Results;
        
        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'Radio'";
        $this->Crud->calldb(0,'SELECT', 0,0,$QR);
        $RD = $this->Crud->Results;
        
        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'IPConnect'";
        $this->Crud->calldb(0,'SELECT', 0,0,$QR);
        $IPConn = $this->Crud->Results;
        
        $Results = [
            'MPLS' => $MPLS,
            'ADSL' => $ADSL,
            'XDSL' => $XDSL,
            'Radio' => $RD,
            'IPConn' => $IPConn
        ];
        
        if($Return == true):
            return $Results;
        else:
            echo json_encode($Results);
        endif;
    }

    private function getPeriodo($Days_Month) {
        $Data = [];
        if ($Days_Month == '30' or $Days_Month == '60' or $Days_Month == '90'):
            $Data[] = date('Y-m-d', strtotime("-{$Days_Month} days"));
        else:
            $Data[] = date('Y-m-d', strtotime("-{$Days_Month} month"));
        endif;

        $Data[] = date("Y-m-d");
        return $Data;
    }
}
