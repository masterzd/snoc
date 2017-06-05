<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ultilitario extends CI_Controller {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->Model('Crud');
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

    public function DataUsa($Data) {
        $DT = explode("-", $Data);
        $DateUSA = $DT[2] . "-" . $DT[1] . "-" . $DT['0'];
        return $DateUSA;
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
        $this->Worktime($NumCh, $HrUP, $HrDW, $difftime);
    }

    public function TimeIndsNow($Oco) {
        $QR = "SELECT TIMEDIFF(now(), tb_ocorrencias.o_hr_dw)o_timeoff FROM tb_ocorrencias WHERE o_cod = {$Oco}";
        $this->CI->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        if (!empty($this->CI->Crud->Results['Dados'])):
            return $this->CI->Crud->Results['Dados'][0]['o_timeoff'];
        else:
            return '00:00:00';
        endif;
    }

    private function Worktime($NumCh, $HrUP, $HrDW, $DIF) {
        $worktime = $this->calc_data($HrUP, $HrDW, $DIF);
        $where = array('o_cod' => $NumCh);
        $Time = array('o_time_ind' => $DIF, 'o_time_work' => $worktime);
        $this->CI->Crud->calldb('tb_ocorrencias', 'UPDATE', $Time, $where);
    }

    public function ConvSeg($Data) {
        $termo = "T";
        /* Condição Para checar a variável data */
        if (strstr($Data, $termo) == TRUE):
            $quebradata = explode('T', $Data);
        else:
            $quebradata = explode(' ', $Data);
        endif;
        /* Lista de variáveis geradas a partir do explode feito na variável Data */
        list($data, $hora) = $quebradata;

        /* Fragmentamos a variável $data e separamos em 3 variáveis com os valores de ano, mes, dia */
        $ArData = explode('-', $data);
        list($ano, $mes, $dia) = $ArData;

        /* Fragmentamos a variável $hora e separamos em 3 variáveis com os valores de hora, minuto, segundo */
        $ArHora = explode(':', $hora);
        list($hora, $min) = $ArHora;
        $seg = 00;

        /* conversão dos valores para segundos. */
        $DataConv = mktime($hora, $min, $seg, $mes, $dia, $ano);

        return $DataConv;
    }

    public function HourForSecond($Hora) {
        $Horas = substr($Hora, 0, -6);
        $Min = substr($Hora, -5, 2);
        $Seg = substr($Hora, -2);
        return $Horas * 3600 + $Min * 60 + $Seg;
    }

    public function ConvHorasMin($Hora) {
        $BrokeHour = explode(":", $Hora);
        $Min = $BrokeHour[0] * 60;
        $Min = $Min + $BrokeHour[1];
        return $Min;
    }

    public function ChecaBandeira($numlj) {

        if ($numlj and $numlj != NULL):
            if ($numlj >= 4000 and $numlj <= 4999):
                $Band = 'IN';
            elseif ($numlj >= 5000 and $numlj <= 5999):
                $Band = 'RE';
            elseif ($numlj >= 2000 and $numlj <= 2999):
                $Band = 'CS';
            elseif ($numlj >= 1000 and $numlj <= 1999):
                $Band = 'SF';
            elseif ($numlj >= 6000 and $numlj <= 8999):
                $Band = 'CL';
            elseif ($numlj >= 9000 and $numlj <= 9999):
                $Band = 'ES';
            elseif ($numlj >= 3000 and $numlj <= 3999):
                $Band = 'CD';
            endif;

            return $Band;
        else:
            die('Erro ao Verificar a Bandeira');
        endif;
    }

    public function ChecklinkExistis($Link, array $ARR) {

        foreach ($ARR as $LNK):
            if (in_array($Link, $LNK)) {
                return true;
            }
        endforeach;
    }

    public function calc_data($horaup, $horadown, $tempInds) {
        //tempo  do expediente em minutos 
        $ini_exp = 510; // inicio
        $fim_exp = 1050; // fim 
        $total_exp = $fim_exp - $ini_exp;


        //separando data de hora
        $horacaiu = explode(' ', $horadown);
        $horavoltou = explode(' ', $horaup);

        //separando data, mes, ano

        $datacaiu = explode("-", $horacaiu[0]);
        $datavoltou = explode("-", $horavoltou[0]);

        // fragmentando horas, min, 00:00:0seg
        $horacaiuH = explode(":", $horacaiu[1]);
        $horavoltouH = explode(":", $horavoltou[1]);
        $tempIndsH = explode(":", $tempInds);

        // pegando o valor de horas e multiplicando por 60 pra converter em minutos
        $horacaiuMin = $horacaiuH[0] * 60;
        $horavoltouMin = $horavoltouH[0] * 60;
        $tempIndsMin = $tempIndsH[0] * 60;

        // somando o a conversão em minutos com os minutos restantes da hora
        $totalminC = $horacaiuMin + $horacaiuH[1];
        $totalminV = $horavoltouMin + $horavoltouH[1];
        $totaltempindsMIN = $tempIndsMin + $tempIndsH[1];

        //intervalo entre um exediente e outro
        $intervalo = 840; // são 14:00:00

        if ($totaltempindsMIN < 1440) {
            if ($totalminC >= $ini_exp and $totalminC <= $fim_exp) {// O bloco abaixo é executado quando o link cai durante o expediente.
                If ($totalminV >= $ini_exp and $totalminV <= $fim_exp) { // O bloco abaixo é executado quando o link volta durante o expediente.
                    if ($totaltempindsMIN >= $intervalo) { // o bloco abaixo é executado quando o link cai durante o expediente e volta durante o expediente do outro dia
                        $subtempo = $totaltempindsMIN - $intervalo;
                        $conv_hora = floor($subtempo / 60);
                        $resto = $subtempo % 60;
                        $total = $conv_hora . ':' . $resto . ':00';
                        return $total;
                    } else { // esse bloco é executado quando o link cai durante o expediente e volta durante o mesmo expediente
                        $subtempo = $totalminV - $totalminC;
                        $conv_hora = floor($subtempo / 60);
                        $resto = $subtempo % 60;
                        $total = $conv_hora . ':' . $resto . ':00';
                        return $total;
                    }
                } else {// o bloco abaixo é executado quando o link cai durante o expediente e volta fora o expediente
                    $totalminV = $fim_exp;
                    $subtempo = $totalminV - $totalminC;
                    $conv_hora = floor($subtempo / 60);
                    $resto = $subtempo % 60;
                    $total = $conv_hora . ':' . $resto . ':00';
                    return $total;
                }
            } else {// esse bloco é executado quando o link cai fora do exediente
                If ($totalminV >= $ini_exp and $totalminV < $fim_exp) {// esse bloco é executado quando o link cai fora do expediente e volta durante o expediente
                    $totalminC = $ini_exp;
                    $subtempo = $totalminV - $totalminC;
                    $conv_hora = floor($subtempo / 60);
                    $resto = $subtempo % 60;
                    $total = $conv_hora . ':' . $resto . ':00';
                    return $total;
                } else {// esse bloco é executado quando o link cai fora do expediente e volta fora do expediente
                    if ($totalminC >= $fim_exp and $totalminV <= $ini_exp) {

                        $total = '00:00:00';
                        return $total;
                    } else {
                        if ($totalminC > 360 and $totalminV < 480) {
                            $total = '00:00:00';
                            return $total;
                        } else {

                            $total = '9:00:00';
                            return $total;
                        }
                    }
                }
            }
        } else {// esse bloco é executado quando o tempo de indisponibilidade é maior que 24 horas.
            $quebraDC = explode("-", $horacaiu[0]);
            list($anoC, $mesC, $diaC) = $quebraDC;

            $quebraDV = explode(" ", $horaup);
            list($dataV, $horaV) = $quebraDV;

            $datasp = explode("-", $dataV);
            list($anoV, $mesV, $diaV) = $datasp;


            //converte para segundos
            $segC = mktime(00, 00, 00, $mesC, $diaC, $anoC);
            $segV = mktime(00, 00, 00, $mesV, $diaV, $anoV);

            $dif = $segV - $segC;

            $totaldias = (int) floor($dif / (60 * 60 * 24));

            if ($totaldias == 2) {
                $totaldias = $totaldias - 1;
            } else {
                if ($totaldias == 1) {
                    $total = "9:00:00";
                    return $total;
                    return;
                } else {
                    $totaldias = $totaldias - 2;
                }
            }


            $totaldias = $totaldias * $total_exp;

            $pri_dia = $totalminC <= $ini_exp ? $pri_dia = $total_exp : $pri_dia = $fim_exp - $totalminC;
            $ult_dia = $totalminV >= $fim_exp ? $ult_dia = $total_exp : $ult_dia = $totalminV - $ini_exp;

            $totalmin = $totaldias + $pri_dia + $ult_dia;
            $coverteHora = floor($totalmin / 60);
            $pegaresto = $totalmin % 60;
            $total = $coverteHora . ':' . $pegaresto . ':00';

            return $total;
        }
    }

    public function conv_seg($call_funcao) {
        $conv_seg = 0;
        $trata_hora = explode(":", $call_funcao);
        $conv_seg += $trata_hora[0] * 3600;
        $conv_seg += $trata_hora[1] * 60;
        $conv_seg += $trata_hora[2];
        return $conv_seg;
    }

    public function conv_horas($soma_val) {

        $horas_total = floor($soma_val / 3600);
        $soma_val -= $horas_total * 3600;
        $minutos_total = floor($soma_val / 60);
        $soma_val -= $minutos_total * 60;
        $total = $horas_total . ":" . $minutos_total . ":" . $soma_val;
        return $total;
    }

}
