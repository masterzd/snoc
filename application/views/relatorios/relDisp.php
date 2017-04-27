<?php

require APPPATH . 'third_party/PHPExel/Classes/PHPExcel.php';
require APPPATH . 'libraries/Infolojas.php';
//require APPPATH.'third_party/Ultilitario.php';

$Excel = new PHPExcel();
$Loja = new Infolojas();
$Util = new Ultilitario();



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
$Excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$Excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
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
$Excel->getActiveSheet()->setCellValueByColumnAndRow(0, 9, "Periodo  01-09-2016 À 10-09-2016");
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
         $Hora = explode(' ', $Chamados['o_hr_ch']);
         
         var_dump($Chamados['o_loja']);
         $Band = $Util->ChecaBandeira($Chamados['o_loja']);
         
         var_dump($Loja->DadosLoja);
         
         
         $Excel->getActiveSheet()->setCellValueByColumnAndRow(0, $Line, $Hora[0]);
         $Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $Line, $Hora[1]);
         $Excel->getActiveSheet()->setCellValueByColumnAndRow(2, $Line, $Band);
         $Excel->getActiveSheet()->setCellValueByColumnAndRow(3, $Line, $Chamados['o_loja']);
        
         $CkeckMainLink = $Util->ChecklinkExistis('MPLS', $Loja->DadosLoja['Links']);
         $StatusMainLink = ( $CkeckMainLink == true ? ($Chamados['o_link'] == 'MPLS' ? 'OFF' : 'ON') : 'NAO POSSUI');
         $QTDLNK = count($Loja->DadosLoja['Links']) - 1;
         $StatusSecondLink = ($QTDLNK >= 1 ? ($Chamados['o_status'] != 'Loja Offline'? 'ON' : 'OFF') :'NAO POSSUI');
         
         if(($StatusMainLink == 'ON' and $StatusSecondLink == 'ON') or 
           ($StatusMainLink == 'OFF' and $StatusSecondLink == 'ON') or 
           ($StatusMainLink == 'ON' and $StatusSecondLink == 'OFF') or
           ($StatusMainLink == 'NAO POSSUI' and $StatusSecondLink == 'ON') or
           ($StatusMainLink == 'ON' and $StatusSecondLink == 'NAO POSSUI')):
             $Operacional = 'SIM';
         elseif($StatusMainLink == 'OFF' and $StatusSecondLink == 'OFF' or 
               ($StatusMainLink == 'NAO POSSUI' and $StatusSecondLink == 'NAO POSSUI')):
             $Operacional = 'NAO';
         else:
             $Operacional = 'NInfo';
         endif;
         
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(4, $Line, $StatusMainLink);
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(5, $Line, $StatusSecondLink);
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(6, $Line, $Operacional);
        
        
        
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
    );


$Excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A7')->applyFromArray($Style['CabecalhoLn1']);
$Excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A8')->applyFromArray($Style['CabecalhoLn2']);
$Excel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A9')->applyFromArray($Style['CabecalhoLn3']);
$Excel->getActiveSheet()->getStyle('A10:J10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$Excel->getActiveSheet()->getStyle('A10:J10')->applyFromArray($Style['CabecalhoLn4']);


/* Criando auto Filtro */
$Excel->getActiveSheet()->setAutoFilter('A10:J10');



/* Finalizando a geração do arquivo */
//$Excel->getActiveSheet()->setTitle('Disponibilidade');
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="Planilha de Indisponiblidade.xls"');
//header('Cache-Control: max-age=0');
//
//$Writer = PHPExcel_IOFactory::createWriter($Excel, 'Excel5');
//$Writer->save('php://output');
