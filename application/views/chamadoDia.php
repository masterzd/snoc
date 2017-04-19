<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Ocorrências Diárias - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/ocorrenciasDiarias.css') ?>"> 
    </head>
    <body>
        <?php
        session_start();
        $this->load->view('commom/menu.php');
        require APPPATH . 'third_party/Ultilitario.php';
        $util = new Ultilitario();
        ?>
        <div class="container-fluid">            
            <div class="row">
                <div class="col-md-10 col-xs-10 first">
                    <header>
                        <h1>Ocorrências Diárias</h1>
                    </header>
                    <main>                   
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <caption>Ocorrências de Hoje, <?= date('d-m-Y') ?></caption>
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Sit. Ocor.</th>
                                        <th>Num. Ocor.</th>
                                        <th>Loja</th>
                                        <th>Link</th>								
                                        <th class="hidden-table">Designação</th>
                                        <th class="hidden-table">Data/Hora Indisponiblidade</th>								
                                        <th class="hidden-table">Prazo de Normalização</th>	
                                        <th class="hidden-table">Hora da Normalização</th>	
                                        <th class="hidden-table">Aberto por:</th>	
                                        <th class="hidden-table">Fechado por:</th>	
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($abHoje)):
                                        foreach ($abHoje as $Day):
                                            echo "
                                            <tr>
                                                <td>{$Day['o_sit_ch']}</td>
                                                <td>{$Day['o_cod']}</td>
                                                <td>{$Day['o_loja']}</td>
                                                <td>{$Day['o_link']}</td>
                                                <td>{$Day['o_desig']}</td>
                                                <td>{$util->DataBR($Day['o_hr_dw'])}</td>
                                                <td>{$util->DataBR($Day['o_prazo'])}</td>
                                                <td>{$util->DataBR($Day['o_hr_up'])}</td>
                                                <td>{$Day['o_opr_ab']}</td>
                                                <td>{$Day['o_opr_op']}</td>
                                            </tr>  
                                            ";
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                            <table class="table table-striped">
                                <caption>Ocorrências de dias anteriores fechadas hoje, <?= date('d-m-Y') ?></caption>
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Data Ocor.</th>
                                        <th>Num. Ocor.</th>
                                        <th>Loja</th>
                                        <th>Link</th>								
                                        <th class="hidden-table">Designação</th>
                                        <th class="hidden-table">Data/Hora Indisponiblidade</th>								
                                        <th class="hidden-table">Prazo de Normalização</th>	
                                        <th class="hidden-table">Aberto por:</th>	
                                        <th class="hidden-table">Fechado por:</th>	
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($fcHoje)):
                                        foreach ($fcHoje as $fcDay):
                                            echo "
                                            <tr>
                                                <td>{$util->DataBR($fcDay['o_hr_fc'])}</td>
                                                <td>{$fcDay['o_cod']}</td>
                                                <td>{$fcDay['o_loja']}</td>
                                                <td>{$fcDay['o_link']}</td>
                                                <td>{$fcDay['o_desig']}</td>
                                                <td>{$util->DataBR($fcDay['o_hr_dw'])}</td>
                                                <td>{$util->DataBR($fcDay['o_hr_up'])}</td>
                                                <td>{$fcDay['o_opr_ab']}</td>
                                                <td>{$fcDay['o_opr_op']}</td>
                                            </tr>  
                                            ";
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </main>
                </div>
            </div>
            <div class="row"></div>
        </div>




        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
    </body>
</html>
