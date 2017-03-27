<?php

function PassGer($T, $M, $Min, $Num, $SB) {

    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '@#$%';


    $Retorno = '';
    $Caracteres = '';

    $Caracteres .= $lmin;
    if ($M):
        $Caracteres .= $lmai;
    endif;
    if ($Num):
        $Caracteres .= $num;
    endif;
    if ($SB):
        $Caracteres .= $simb;
    endif;

    $len = strlen($Caracteres);

    for ($n = 1; $n <= $T; $n++):
        $rand = mt_rand(1, $len);
        $Retorno .= $Caracteres[$rand - 1];
    endfor;

    return $Retorno;
}

function ChecaBandeira($numlj) {
        
    if ($numlj and $numlj != NULL):
        
        if($numlj >= 4000 and $numlj <= 4999):
            $Band = 1;
        elseif($numlj >= 5000 and $numlj <= 5999):
            $Band = 2;
        elseif($numlj >= 2000 and $numlj <= 2999):
            $Band = 3;
        elseif($numlj >= 1000 and $numlj <= 1999):
            $Band = 4;
        elseif($numlj >= 6000 and $numlj <= 8999):
            $Band = 5;
        elseif($numlj >= 9000 and $numlj <= 9999):
            $Band = 6;
        elseif($numlj >= 3000 and $numlj <= 3999):
            $Band = 7;
        endif;     
        return $Band;
    else:
        die('Erro ao Verificar a Bandeira');
    endif;
}

function CheckRespTec($Estado, $Band) {
    if (($Band == 1 or $Band == 2 or $Band == 7) and ( $Estado == "BA" or $Estado == "SE")): 
        return 8;
    elseif (($Band == 1 or $Band == 2 or $Band == 6 or $Band == 7) and ( $Estado == "AL" or $Estado == "PE" or $Estado == "PB" or $Estado == "RN" or $Estado == "CE")): 
        return 3;
    elseif ($Band == 1 or $Band == 5 or $Band == 7 and ( $Estado == "MA" or $Estado == "PI" or $Estado == "MT" or $Estado == "MS" or $Estado == "RO" or $Estado == "AM" or $Estado == "AC" or $Estado == "RR" or $Estado == "TO" or $Estado == "PA")): 
        return 7;
    elseif (($Band == 2 or $Band == 7) and $Estado == "MG"): 
        return 6;
    elseif (($Band == 2 or $Band == 7) and $Estado == "ES"): 
        return 1;
    elseif (($Band == 2 or $Band == 7) and $Estado == "SP"): 
        return 10;
    elseif (($Band == 2 or $Band == 7) and $Estado == "RJ"): 
        return 2;
    elseif ($Band == 3 or ( $Band == 7 and $Estado == "GO")): 
        return 5;
    elseif ($Band == 4 or ( $Band == 7 and $Estado == 'PR' or $Estado == 'SC')): 
        return 4;
    elseif ($Band == 8):
        return 11;
    else:
        die("Erro ao Verificar o Responsável técnico!!");
    endif;
}
