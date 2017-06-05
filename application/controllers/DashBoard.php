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

    public function operadora() {
        /* Recuperando a quantidade de chamados de cada link que são direcionados para a operadora */
        $Info['CountOcorrencias'] = $this->getDadosChamadosOperadora(true);

        /* Recuperando os dados que vão ser exibidos da tela de filas */

        /* Consulta Ocorrências da Fila Direcionadas para operadora - 15 min aberto */
        $LinkFila1 = array('MPLS', 'XDSL', 'IPConnect');
        $Fila1 = $this->timeOpenCh('PT15M', $LinkFila1, 'o_last_update', 2, 2);
        
        /* Consulta de Ocorrencias da Fila de Direcionadas para operadora - ADSL acima 1 Hora */
        $LinkFila2 = 'ADSL';
        $Fila2 = $this->timeOpenCh('PT1H', $LinkFila2, 'o_last_update', 2, 2);
        
        /* Consulta de Ocorrencias da Fila Ocorrencias com  prazo de normalização Expirado - MPLS */
        $LinkFila3 = 'MPLS';
        $Fila3 = $this->timeOpenCh(0, $LinkFila3, 'o_prazo', 2, 6);
        
        /* Consulta de Ocorrencias da Fila de Ocorrencias com prazo de normalização expirado - Link backup */
        $LinkFila4 = array('ADSL', 'XDSL', 'IPConnect');
        $Fila4 = $this->timeOpenCh(0, $LinkFila4, 'o_prazo', 2, 6);
         
        $Info['Filas'] = array(
            'Oper_15min' => $Fila1,
            'Oper_1hora' => $Fila2,
            'Oper_Expirado_Prin' => $Fila3,
            'Oper_Expirado_Back' => $Fila4,
        );

        $this->load->view('dashboard/operadora', $Info);
    }

    public function poolingOperadora() {
        set_time_limit(0);
        $In = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($In) and ! empty($In['info'])):
            $Dados = explode('&', $In['info']);
            unset($Dados[5]);
            $Dados = array_values($Dados);
            unset($Dados[7]);

            while (true):
                clearstatcache();
                $Check = $this->getDadosChamadosOperadora(true);
                foreach ($Check as $Info):
                    $Lines[] = $Info['lines'] ?? '0';
                endforeach;
                $DIFF = array_diff_assoc($Lines, $Dados);
                $Lines = null;

                if (count($DIFF) > 0):
                    $Keys = array_keys($DIFF);
                    foreach ($Keys as $key):
                        $Out[] = array($key, $DIFF[$key]);
                    endforeach;
                    echo json_encode($Out);
                    break;
                endif;
                sleep(2);
            endwhile;
        endif;
    }

    public function getDadosChamadosOperadora($Return = false) {

        /* Verifica quantas ocorrências de cada link existe em aberto direcionado para a operadora */
        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'MPLS'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $MPLS = $this->Crud->Results ?? '0';

        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'ADSL'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $ADSL = $this->Crud->Results ?? '0';

        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'XDSL'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $XDSL = $this->Crud->Results ?? '0';

        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'Radio'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $RD = $this->Crud->Results ?? '0';

        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'IPConnect'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $IPConn = $this->Crud->Results ?? '0';

        $QR = "SELECT tb_ocorrencias.o_cod FROM tb_ch_acao, tb_ocorrencias WHERE tb_ocorrencias.o_cod = tb_ch_acao.o_cod AND tb_ch_acao.ch_acao = 'Preventiva Aberta - Operadora' AND tb_ocorrencias.o_sit_ch NOT LIKE 1 AND tb_ocorrencias.o_sit_ch NOT LIKE 8";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $Prev = $this->Crud->Results ?? '0';

        $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_nece = 7 AND o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $Inad = $this->Crud->Results ?? '0';

        $Results = [
            'MPLS' => $MPLS,
            'ADSL' => $ADSL,
            'XDSL' => $XDSL,
            'Radio' => $RD,
            'IPConn' => $IPConn,
            'Prev' => $Prev,
            'Inad' => $Inad
        ];

        if ($Return == true):
            return $Results;
        else:
            echo json_encode($Results);
        endif;
    }

    public function GeraModal() {
        $In = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($In) and is_string($In['id'])):
            $Util = new Ultilitario;
            switch ($In['id']):
                case '0':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'MPLS'";
                    break;
                case '1':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'ADSL'";
                    break;
                case '2':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'XDSL'";
                    break;
                case '3':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'Radio'";
                    break;
                case '4':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2 AND o_link = 'IPConnect'";
                    break;
                case '7':
                    $QR = "SELECT * FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8 AND o_nece = 2";
                    break;
                case '5':
                    $QR = "SELECT tb_ocorrencias.o_cod FROM tb_ch_acao, tb_ocorrencias WHERE tb_ocorrencias.o_cod = tb_ch_acao.o_cod AND tb_ch_acao.ch_acao = 'Preventiva Aberta - Operadora' AND tb_ocorrencias.o_sit_ch NOT LIKE 1 AND tb_ocorrencias.o_sit_ch NOT LIKE 8";
                    break;
                case '6':
                    $QR = "SELECT o_cod FROM tb_ocorrencias WHERE o_nece = 7 AND o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8";
                    break;
                default :
                    echo 'falha';
                    die();
                    break;
            endswitch;
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
            /* Gera Modal */

            if (!empty($this->Crud->Results['Dados'])):
                echo "
            <div class=\"modal-content custom\">
                    <div class=\"modal-header custom-modal\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                        <h3 class=\"modal-title\">Lojas com Incidentes em aberto</h3>
                    </div>
                    <div class=\"modal-corpo\">        
                            <div class=\"table-responsive\">
                                    <table class=\"table table-striped\">
                                                <thead class=\"table-custom\">
                                                    <tr class=\"tb-color\">
                                                        <th class=\"hidden-table\">Num. Ocor.</th>
                                                        <th>Aberto em:</th>
                                                        <th>Hora do Incidente</th>
                                                        <th>Aberto por: </th>
                                                        <th>Protocolo:</th>                                 
                                                        <th>Prazo de Normalização:</th>                                 
                                                    </tr>
                                                </thead>
                                          <tbody>";
                foreach ($this->Crud->Results['Dados'] as $Ch):

                    $Ch['o_hr_ch'] = $Util->DataBR($Ch['o_hr_ch']);
                    $Ch['o_hr_dw'] = $Util->DataBR($Ch['o_hr_dw']);
                    $Ch['o_prazo'] = $Util->DataBR($Ch['o_hr_fc']);
                    echo "<tr>
                                    <td>{$Ch['o_cod']}</td>
                                    <td>{$Ch['o_hr_ch']}</td>
                                    <td>{$Ch['o_hr_dw']}</td>
                                    <td>{$Ch['o_opr_ab']}</td>
                                    <td>{$Ch['o_prot_op']}</td>
                                    <td>{$Ch['o_prazo']}</td>
                                </tr> ";
                endforeach;

                echo "    </tbody>
                        </table>
                    </div>
                  </div>
               </div>
            </div>
                ";
            else:
                echo 'fail';
            endif;

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

    /* Função responsável para calcular quanto tempo o chamado está aberto */

    private function timeOpenCh($DiffTime, $Links, $Field, $Nece, $Sit) {

        $Util = new Ultilitario();

        if (count($Links) > 1):
            $QR = "SELECT TIMEDIFF(NOW(), {$Field})o_tempo, o_loja, o_band, o_link, o_cod, o_hr_ch, o_last_update, o_akl, o_prazo, o_sit_ch,"
                    . " o_op  FROM tb_ocorrencias WHERE o_sit_ch = '{$Sit}' AND  o_nece = '{$Nece}' AND (o_link = '{$Links[0]}' or o_link = '{$Links[1]}' or o_link = '{$Links[2]}')";
        else:
            $QR = "SELECT TIMEDIFF(NOW(), {$Field})o_tempo, o_loja, o_band, o_link, o_prazo ,o_cod, o_akl, o_op, o_last_update "
                    . "FROM tb_ocorrencias WHERE o_sit_ch ='{$Sit}' AND o_nece ='{$Nece}' AND o_link = '{$Links}'";
        endif;

        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $Results = null;
        $Count = 0;

        if (!empty($this->Crud->Results['Dados'])):

            foreach ($this->Crud->Results['Dados'] as $Out):

                if ($Sit == 2 and $Nece == 2):                    
                    $Tempo = new DateTime($Out["{$Field}"]);
                    $Tempo->add(new DateInterval($DiffTime));
                    $ConvArr = (array) $Tempo;
                    $TempoParaFila =  $ConvArr['date'];
                else:
                    $TempoParaFila = $Out['o_prazo'];
                endif;

                $TimeOpenSec = date('Y-m-d H:i:s');

                if (strtotime($TimeOpenSec) > strtotime($TempoParaFila)):
                    $Fila = $this->ChecaFilaDashboard($Nece, $Out['o_link']);
                    $this->TimeDashCh($Fila, $Out);
                    $Results[$Count]['o_tempo'] = $Out['o_tempo'];
                    $Results[$Count]['o_loja'] = $Out['o_loja'];
                    $Results[$Count]['o_band'] = $Out['o_band'];
                    $Results[$Count]['o_link'] = $Out['o_link'];
                    $Results[$Count]['o_prazo'] = $Out['o_prazo'];
                    $Results[$Count]['o_cod'] = $Out['o_cod'];
                    $Results[$Count]['o_akl'] = $Out['o_akl'];
                    $Results[$Count]['o_op'] = $Out['o_op'];
                endif;

                $Count ++;
            endforeach;
            return $Results;
        endif;
    }

    /* Função para Calcular quanto tempo a ocorrência ficou no dashboard */

    private function TimeDashCh($Fila, array $Chamado) {

        $Where = array(
            'ctl_ch' => $Chamado['o_cod'],
            'ctl_fila' => $Fila
        );
        $this->Crud->calldb('tb_control_painel', 'SELECT', $Where);

        if ($this->Crud->Results['lines'] == 0):

            $Dados = [
                'ctl_ch' => $Chamado['o_cod'],
                'ctl_fila' => $Fila,
                'ctl_loja' => $Chamado['o_loja'],
                'ctl_band' => $Chamado['o_band'],
                'ctl_hora_reg' => date('Y-m-d H:i:s'),
                'ctl_time_painel' => '00:00:01'
            ];

            $this->Crud->calldb('tb_control_painel', 'INSERT', $Dados);


        else:

            $QR = "SELECT TIMEDIFF(NOW(), ctl_hora_reg)ctl_diff FROM tb_control_painel WHERE ctl_ch = {$Chamado['o_cod']}";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);

            $UpdateTime = array(
                'ctl_time_painel' => $this->Crud->Results['Dados'][0]['ctl_diff']
            );

            $Whre = array('ctl_ch' => $Chamado['o_cod']);
            $this->Crud->calldb('tb_control_painel', 'UPDATE', $UpdateTime, $Whre);

        endif;
    }

    /* Extensão da função timeOpenCh, que define para qual fila do dashboard a ocorrência foi salva */

    private function ChecaFilaDashboard($Nece, $Link) {

        if ($Nece == 2 and ( $Link == 'MPLS' or $Link == 'XDSL' or $Link == 'IPConnect')):
            $Msg = "Direcionado para o Residente - MPLS / XDSL / IPC";
        elseif ($Nece == 2 and $Link == 'ADSL'):
            $Msg = "Direcionado para o Residente - ADSL";
        endif;

        return $Msg;
    }

}
