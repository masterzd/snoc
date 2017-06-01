<?php

require APPPATH . 'third_party/PHPExel/Classes/PHPExcel.php';
require APPPATH . 'libraries/Infolojas.php';

$Excel = new PHPExcel();
$Loja = new Infolojas();
$Util = new Ultilitario();

ini_set('display_errors', 0);

$Excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

/* Mesclando celulas */
$Excel->setActiveSheetIndex(0)
        ->mergeCells('A7:J7')
        ->mergeCells('A8:J8')
        ->mergeCells('A9:J9');


/* Configurando o tamanho das celulas */
$Excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$Excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$Excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
$Excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);


/* Imagem na planilha */
$IMG = new PHPExcel_Worksheet_Drawing;
$IMG->setWorksheet($Excel->getActiveSheet());
$IMG->setName('Logo RE');
$IMG->setDescription('Ricardo Eletro');
$IMG->setPath("/var/www/CI_SISNOC/assets/img/logoRE.jpg");
$IMG->setCoordinates("A1");

/* Preenchendo tabela com  os dados */

$Excel->getActiveSheet()->setCellValueByColumnAndRow(0, 7, "Levantamento de Interrupções");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(0, 8, "Falhas  Links  Lojas  -  RE  -  ES  -  IN  -  CS  -  CL");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(0, 9, "Periodo  {$Periodo['dataIni']} À {$Periodo['dataFim']}");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(0, 10, "Data");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(1, 10, "Hora");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(2, 10, "Empresa");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(3, 10, "Filial");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(4, 10, "Principal");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(5, 10, "Backup");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(6, 10, "Operacional");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(7, 10, "Minutos Fora");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(8, 10, "Responsabilidade");
$Excel->getActiveSheet()->setCellValueByColumnAndRow(9, 10, "Tempo Indisponível");

$Line = 11;
foreach ($Resultado as $Chamados):

    $Loja->CheckDadosLoja($Chamados['o_loja']);
    $Chamados['o_hr_ch'] = $Util->DataBR($Chamados['o_hr_ch']);
    $Hora = explode('  ', $Chamados['o_hr_ch']);
    $Band = $Util->ChecaBandeira($Chamados['o_loja']);

    $Excel->getActiveSheet()->setCellValueByColumnAndRow(0, $Line, $Hora[0]);
    $Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $Line, $Hora[1]);
    $Excel->getActiveSheet()->setCellValueByColumnAndRow(2, $Line, $Band);
    $Excel->getActiveSheet()->setCellValueByColumnAndRow(3, $Line, $Chamados['o_loja']);

    $CkeckMainLink = $Util->ChecklinkExistis('MPLS', $Loja->DadosLoja['Links']);
    $StatusMainLink = ( $CkeckMainLink == true ? ($Chamados['o_link'] == 'MPLS' ? 'OFF' : 'ON') : 'NAO POSSUI');
    $QTDLNK = count($Loja->DadosLoja['Links']) - 1;
    $StatusSecondLink = ($QTDLNK >= 1 ? ($Chamados['o_status'] != 'Loja Offline' ? 'ON' : 'OFF') : 'NAO POSSUI');

    if (($StatusMainLink == 'ON' and $StatusSecondLink == 'ON') or ( $StatusMainLink == 'OFF' and $StatusSecondLink == 'ON') or ( $StatusMainLink == 'ON' and $StatusSecondLink == 'OFF') or ( $StatusMainLink == 'NAO POSSUI' and $StatusSecondLink == 'ON') or ( $StatusMainLink == 'ON' and $StatusSecondLink == 'NAO POSSUI')):
        $Operacional = 'SIM';
    elseif ($StatusMainLink == 'OFF' and $StatusSecondLink == 'OFF' or ( $StatusMainLink == 'NAO POSSUI' and $StatusSecondLink == 'NAO POSSUI')):
        $Operacional = 'NAO';
    else:
        $Operacional = 'NInfo';
    endif;

    $Excel->getActiveSheet()->setCellValueByColumnAndRow(4, $Line, $StatusMainLink);
    $Excel->getActiveSheet()->setCellValueByColumnAndRow(5, $Line, $StatusSecondLink);
    $Excel->getActiveSheet()->setCellValueByColumnAndRow(6, $Line, $Operacional);

    /* ================== Preenchendo os dados no campo Minutos fora ====================== */

    if ($Chamados['o_sit_ch'] == 1 or $Chamados['o_sit_ch'] == 8):
        $Seg = $Util->ConvHorasMin($Chamados['o_time_ind']);
    elseif (($Chamados['o_sit_ch'] >= 2 and $Chamados['o_sit_ch'] <= 7) or ( $Chamados['o_sit_ch'] == 0)):
        $SegHourDown = $Util->ConvSeg($Chamados['o_hr_dw']);
        $SegCurrentHour = $Util->ConvSeg(date('Y-m-d H:i:s'));
        $Seg = ($SegCurrentHour - $SegHourDown) / 60;
    endif;

    $Excel->getActiveSheet()->setCellValueByColumnAndRow(7, $Line, $Seg);

    /* =================== Preenchendo os dados no campo responsabilidade ================== */
    if ($Chamados['o_sit_ch'] == 1 or $Chamados['o_sit_ch'] == 8):
        $respon = $Chamados['o_causa_prob'];
    else:
        $respon = 'Não definido - Ocorrência aberta';
    endif;

    $Excel->getActiveSheet()->setCellValueByColumnAndRow(8, $Line, $respon);

    /* =================== Preeenchendo os dados no campo tempo indisponível ============== */
    if ($Chamados['o_sit_ch'] == 1 or $Chamados['o_sit_ch'] == 8):
        $timeInd = $Chamados['o_time_ind'];
    else:
        $timeInd = $Util->TimeIndsNow($Chamados['o_cod']);
    endif;



    $Excel->getActiveSheet()->setCellValueByColumnAndRow(9, $Line, $timeInd);
    $Line ++;
endforeach;


/* Estilizando a Tabela */
/* Estilizando Cabeçalho */
$Style = array(
    'CabecalhoLn1' => array(
        'font' => array(
            'size' => 10,
            'color' => array('rgb' => 'ff3f2d'),
            'bold' => true
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fccb3a')
        ),
    ),
    'CabecalhoLn2' => array(
        'font' => array(
            'size' => 10,
            'bold' => true
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fccb3a')
        )
    ),
    'CabecalhoLn3' => array(
        'font' => array(
            'size' => 10,
            'bold' => true
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '3080d1')
        )
    ),
    'CabecalhoLn4' => array(
        'font' => array(
            'size' => 10,
            'bold' => true,
            'color' => array('rgb' => 'ffffff'),
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '000000')
        )
    ),
    'alinhamento' => array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
    )
);


$Excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A7')->applyFromArray($Style['CabecalhoLn1']);
$Excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A8')->applyFromArray($Style['CabecalhoLn2']);
$Excel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A9')->applyFromArray($Style['CabecalhoLn3']);
$Excel->getActiveSheet()->getStyle('A10:J10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A10:J10')->applyFromArray($Style['CabecalhoLn4']);
$Excel->getActiveSheet()->getDefaultStyle()->applyFromArray($Style['alinhamento']);


/* Criando auto Filtro */
$Excel->getActiveSheet()->setAutoFilter('A10:J10');



/* Finalizando a geração do arquivo */
$Excel->getActiveSheet()->setTitle('Disponibilidade');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Planilha de Indisponiblidade.xls"');
header('Cache-Control: max-age=0');

$Writer = PHPExcel_IOFactory::createWriter($Excel, 'Excel5');
$Writer->save('php://output');
