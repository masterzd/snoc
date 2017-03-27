<?php         
require 'Config.inc.php';
function DataBR($Data) {
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

function CheckDestinatários($Enc, $TecCod = NULL){
    
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
    
    if($Enc == 2):
        $D = array($Destinatarios['Sup. Noc'], $Destinatarios['Res. Ope1'], $Destinatarios['Res. Ope2']);
    elseif($Enc == 3):
        $C = new Consulta();
        $C->ExeLer('tb_resp_tec', 'WHERE resp_cod = :cod', "cod={$TecCod}");
        $A = $C->pegarResultados();
        $D = array($A[0]['resp_email'], $Destinatarios['Sup. Noc']);
    elseif($Enc == 4):
        $D = array($Destinatarios['Sup. Noc']);
    elseif($Enc == 5):
        $D = array($Destinatarios['Sup. Noc'], $Destinatarios['Noc']);
    endif;
    
    return $D; 
}

function prazoFaltadeEnergia(){   
    $time = new DateTime(date("Y-m-d H:i:s"));
    $time->add(new DateInterval("PT2H"));
    $Prazo = (array) $time;
    return $Prazo['date'];    
}

function prazoTecnico(){   
    $time = new DateTime(date("Y-m-d H:i:s"));
    $time->add(new DateInterval("P2D"));
    $Prazo = (array) $time;
    return $Prazo['date'];  
}