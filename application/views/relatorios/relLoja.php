<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require APPPATH."third_party/mpdf60/mpdf.php";
        $PDF = new mPDF();
        
        
        $RenderReport = "
           <header>
             <img src='". base_url('assets/img/SNOC3.png')."' class='rel-img'>
             <h3>Relatório da Loja: {$Periodo['lj_num']}</h3> 
             <h3>Período: {$Periodo['dataIni']} a {$Periodo['dataFim']}</h3> 
           </header>              
           <main>
               <table>
                      <caption>Ricardo Eletro</caption>  
                      <thead>
                           <tr>
                                <th>Num. Ocor.</th>    
                                <th>Circuito</th>
                                <th>Operadora</th>
                                <th>Link</th>
                                <th>Hora da Ocorrência</th>
                           </tr> 
                      </thead>
                  <tbody>";
                    foreach ($Resultados as $Ch):
                        $RenderReport .= "  
                                <tr>
                                    <td>{$Ch['o_cod']}</td>
                                    <td>{$Ch['o_desig']}</td>
                                    <td>{$Ch['o_op']}</td>
                                    <td>{$Ch['o_link']}</td>
                                    <td>{$Ch['o_hr_ch']}</td>
                                </tr>
                             ";
                    endforeach;
            $RenderReport .= "
                        </tbody>
                    </table>
                </main>";
        $CSS = file_get_contents(base_url('assets/css/custom-css/relatorios/relGeral.css'));
        $PDF->WriteHTML($CSS,1);
        $PDF->WriteHTML($RenderReport);
        $PDF->Output();
        ?>
    </body>
</html>
