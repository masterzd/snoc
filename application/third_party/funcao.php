<?php

function calc_data($horaup, $horadown, $tempInds) {
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

function conv_seg($call_funcao) {
    $conv_seg = 0;
    $trata_hora = explode(":", $call_funcao);
    $conv_seg += $trata_hora[0] * 3600;
    $conv_seg += $trata_hora[1] * 60;
    $conv_seg += $trata_hora[2];
    return $conv_seg;
}

function conv_horas($soma_val) {

    $horas_total = floor($soma_val / 3600);
    $soma_val -= $horas_total * 3600;
    $minutos_total = floor($soma_val / 60);
    $soma_val -= $minutos_total * 60;
    $total = $horas_total . ":" . $minutos_total . ":" . $soma_val;
    return $total;
}

?>