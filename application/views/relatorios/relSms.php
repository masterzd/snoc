<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
        require APPPATH . "third_party/mpdf60/mpdf.php";
        $PDF = new mPDF();


        $RenderReport = "
           <header>
             <img src='" . base_url('assets/img/SNOC3.png') . "' class='rel-img'>
             <h3>Relatório SMS do Período: {$Periodo['dataIni']} a {$Periodo['dataFim']}</h3> 
             <h4>Dados Gerais:</h4>
             <p>{$envFull} Mensagens enviadas. </p>
             <p>Mensagens Enviadas com sucesso: {$envSucess} </p>
             <p>Mensagens não Enviadas: {$envFalse}</p>
           </header>              
           <main>
               <h4>Detalhes:</h4>
               <table>
                      <caption>Ricardo Eletro</caption>  
                      <thead>
                           <tr>
                                <th>Data Envio</th>    
                                <th>Status</th>
                                <th>Loja</th>
                                <th>Chamado</th>
                                <th>Numero Dest.</th>
                           </tr> 
                      </thead>
                  <tbody>";
                    foreach ($Dados as $Ch):
                        $Ch['sms_sit_env'] = $Ch['sms_sit_env'] != '000' ? 'Enviado' : 'Falha';
                        $RenderReport .= "  
                            <tr>
                                <td>{$Ch['sms_date']}</td>
                                <td>{$Ch['sms_sit_env']}</td>
                                <td>{$Ch['sms_loja']}</td>
                                <td>{$Ch['sms_ch']}</td>
                                <td>{$Ch['sms_num']}</td>
                            </tr>";
                    endforeach;
                $RenderReport .= "
                                </tbody>
                            </table>
                        </main>";

        $CSS = file_get_contents(base_url('assets/css/custom-css/relatorios/relGeral.css'));
        $PDF->WriteHTML($CSS, 1);
        $PDF->WriteHTML($RenderReport);
        $PDF->Output();
//        echo $RenderReport;
        ?>
    </body>
</html>
