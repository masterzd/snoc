<?php

require APPPATH . 'third_party/PHPExel/Classes/PHPExcel.php';
require APPPATH . 'libraries/Infolojas.php';

$objPHPExcel = new PHPExcel();
$Loja = new Infolojas();
$Util = new Ultilitario();


ini_set('display_errors', 1);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

/* Mesclando celulas */
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A7:J7')
        ->mergeCells('A8:J8')
        ->mergeCells('A9:J9');


/* Configurando o tamanho das celulas */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);


/* Imagem na planilha */
$IMG = new PHPExcel_Worksheet_Drawing;
$IMG->setWorksheet($objPHPExcel->getActiveSheet());
$IMG->setName('Logo RE');
$IMG->setDescription('Ricardo Eletro');
$IMG->setPath("/var/www/CI_SISNOC/assets/img/logoRE.jpg");
$IMG->setCoordinates("A1");

/* Preenchendo tabela com  os dados */

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 7, "Produtividade do NOC");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 8, " Ocorrências Abertas e Fechadas");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 9, "Periodo {$data_Ini} á {$data_Fim} ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 10, "Ocorrência");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 10, "Status da Ocorrência");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 10, "Data de Abertura");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 10, "Aberto por:");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 10, "Data de Fechamento");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 10, "Fechado por:");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 10, "Link");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 10, "Operadora");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 10, "Circuito");


$Line = 11;
foreach ($Ocorrências as $Chamados):

    /* Checar status da ocorrencia */
    if ($Chamados['o_sit_ch'] == 1):
        $Sit = "Fechado";
    else:
        $Sit = "Aberto";
    endif;

    $DataAB = $Util->DataBR($Chamados['o_hr_ch']);
    $DataFC = $Util->DataBR($Chamados['o_hr_fc']);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $Line, "{$Chamados['o_cod']}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $Line, "{$Sit}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $Line, "{$DataAB}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $Line, "{$Chamados['o_opr_ab']}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $Line, "{$DataFC}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $Line, "{$Chamados['o_opr_fc']}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $Line, "{$Chamados['o_link']}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $Line, "{$Chamados['o_op']}");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $Line, "{$Chamados['o_desig']}");

    $Line = $Line + 1;


endforeach;

$Align = [
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ]
];

$objPHPExcel->getDefaultStyle()->applyFromArray($Align);

$objPHPExcel->getActiveSheet()->setTitle('Produtividade NOC');
$objPHPExcel->getActiveSheet()->getStyle("A7:J7")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle("A8:J8")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle("A9:J9")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Produtividade NOC.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;