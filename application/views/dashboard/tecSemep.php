<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/dashboard/tecSemep.css') ?>">
        <title>Dashboard - Tec.Regionais e SEMEP</title>
        <meta http-equiv="refresh" content="300">
        <?php $Util = new Ultilitario(); ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <header>
                        <h1>DashBoard - Ocorrências Abertas Téc. Regionais e SEMEP</h1>
                    </header>
                    <main>
                        <div class="ctl-card">

                            <div class="card j-tec-reg">
                                <p id="0" class="count"><?= $Tec['QtCh'] ?></p>
                                <div class="cont">
                                    <h4><b>Téc Regionais</b></h4>
                                </div>
                            </div>

                            <div class="card j-semep">
                                <p id="0" class="count"><?= $Semep['QtCh'] ?></p>
                                <div class="cont">
                                    <h4><b>SEMEP</b></h4>
                                </div>
                            </div>

                        </div>
                    </main>
                </div>
            </div>
            <div class="row">
                <header>
                    <h5>Filas das ocorrências emcaminhadas para técnicos e SEMEP</h5>
                </header>
                <div class="card card-large">
                    <div class="cont">
                        <h4><b>Emcaminhadas para o técnico regional - Mais de 24 Horas.</b></h4>
                    </div>
                    <div class="col-md-12 col-xs-12 table-tam">
                        <div class="table-responsive Oper_15min">
                            <table class="table table-striped">
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Num. Ocor</th>
                                        <th>Loja</th>
                                        <th>Link</th>
                                        <th>Operadora</th>
                                        <th>Tempo Aberto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($Tec['ChTimeAB'])):
                                        foreach ($Tec['ChTimeAB'] as $Oc):
                                            echo "<tr id='{$Oc['o_cod']}'>";
                                            echo "<td>{$Oc['o_cod']}</td>";
                                            echo "<td>{$Oc['o_loja']}</td>";
                                            echo "<td>{$Oc['o_link']}</td>";
                                            echo "<td>{$Oc['o_op']}</td>";
                                            echo "<td class='j-timeab'>{$Oc['o_tempo']}</td>";
                                            echo '</tr>';
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-large">
                    <div class="cont">
                        <h4><b>Ocorrências SEMEP mais de 72 Horas</b></h4>
                    </div>
                    <div class="col-md-12 col-xs-12 table-tam">
                        <div class="table-responsive Oper_1hora">
                            <table class="table table-striped">
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Num. Ocor</th>
                                        <th>Loja</th>
                                        <th>Link</th>
                                        <th>Operadora</th>
                                        <th>Tempo Aberto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($Semep['ChTimeAB'])):
                                        foreach ($Semep['ChTimeAB'] as $Oc):
                                            echo "<tr id='{$Oc['o_cod']}'>";
                                            echo "<td>{$Oc['o_cod']}</td>";
                                            echo "<td>{$Oc['o_loja']}</td>";
                                            echo "<td>{$Oc['o_link']}</td>";
                                            echo "<td>{$Oc['o_op']}</td>";
                                            echo "<td class='j-timeab'>{$Oc['o_tempo']}</td>";
                                            echo '</tr>';
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="mdlinfoTec" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content custom">
                        <div class="modal-header custom-modal">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Ocorrências abertas emcaminhadas para o técnico regional</h3>
                        </div>
                        <div class="modal-corpo">
                            <div class="table-responsive" id="edit-table">
                                <table class="table table-striped">
                                    <thead class="table-custom">
                                        <tr class="tb-color">
                                            <th>Num. Ocor.</th>
                                            <th>Aberto em:</th>
                                            <th>Chamado OTRS:</th>
                                            <th>Hora do Incidente:</th>                                            
                                            <th>Aberto por:</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($Tec['ChAll'] as $Info):
                                            $Info['o_hr_ch'] = $Util->DataBR($Info['o_hr_ch']);
                                            $Info['o_hr_dw'] = $Util->DataBR($Info['o_hr_dw']);
                                            echo " <tr>
                                                    <td>{$Info['o_cod']}</td>
                                                    <td>{$Info['o_hr_ch']}</td>
                                                    <td>{$Info['o_otrs']}</td>
                                                    <td>{$Info['o_hr_dw']}</td>
                                                    <td>{$Info['o_opr_ab']}</td>
                                                </tr>";
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="mdlinfoSemep" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content custom">
                        <div class="modal-header custom-modal">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Ocorrências abertas emcaminhadas para o SEMEP</h3>
                        </div>
                        <div class="modal-corpo">
                            <div class="table-responsive" id="edit-table">
                                <table class="table table-striped">
                                    <thead class="table-custom">
                                        <tr class="tb-color">
                                            <th>Num. Ocor.</th>
                                            <th>Aberto em:</th>
                                            <th>Chamado SISMAN:</th>
                                            <th>Hora do Incidente:</th>
                                            <th>Aberto por:</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($Semep['ChAll'] as $Info):
                                            $Info['o_hr_ch'] = $Util->DataBR($Info['o_hr_ch']);
                                            $Info['o_hr_dw'] = $Util->DataBR($Info['o_hr_dw']);
                                            echo " <tr>
                                                    <td>{$Info['o_cod']}</td>
                                                    <td>{$Info['o_hr_ch']}</td>
                                                    <td>{$Info['o_sisman']}</td>
                                                    <td>{$Info['o_hr_dw']}</td>
                                                    <td>{$Info['o_opr_ab']}</td>
                                                </tr>";
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/tecSemep.js') ?>"></script>
    </body>
</html>
