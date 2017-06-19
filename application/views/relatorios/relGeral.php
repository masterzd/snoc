<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Relatório Geral</title>
    </head>
    <body>
        <?php
          require APPPATH."third_party/mpdf60/mpdf.php";
          $PDF = new mPDF();
          $PDF->debug = false;
          
          $RenderReport = "
           <header>
            
             <h3>Relatório do Período: {$Periodo['dataIni']} a {$Periodo['dataFim']}</h3> 
             <h4>Dados Gerais:</h4>
             <p>{$Geral['chGerPer']} ocorrência(s) realizadas durante o período.</p>
             <p>Ocorrência(s) abertas de MPLS: {$Geral['chGerMPLS']} </p>
             <p>Ocorrência(s) abertas de link de backup: {$Geral['chAGerBK']}</p>
           </header>              
           <main>
               <h4>Detalhes:</h4>
               <table>
                      <caption>Ricardo Eletro</caption>  
                      <thead>
                           <tr>
                                <th>Num. Ocor.</th>    
                                <th>Loja</th>
                                <th>Circuito</th>
                                <th>Operadora</th>
                                <th>Link</th>
                                <th>Hora da Ocorrência</th>
                           </tr> 
                      </thead>
                  <tbody>";
                    foreach ($Ocorrencias['offOperadora'] as $Ch):
                        $RenderReport .= "  
                                <tr>
                                    <td>{$Ch['o_cod']}</td>
                                    <td>{$Ch['o_loja']}</td>
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
        $PDF->Output('RelatorioGeral.pdf', 'D');
        ?>
    </body>
</html>
