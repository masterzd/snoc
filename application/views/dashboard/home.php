<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/dashboard/home.css') ?>">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <title>Dashboard - Home</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <header>
                        <h1>DashBoard - Informações Gerais</h1>
                    </header>
                    <main>
                        <div class="ctl-card">
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Lojas Cadastradas</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $MPLS ?></p>
                                <div class="cont">
                                    <h4><b>Links MPLS</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $ADSL ?></p>
                                <div class="cont">
                                    <h4><b>Links ADSL</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $XDSL ?></p>
                                <div class="cont">
                                    <h4><b>Links XDSL</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $MB4G ?></p>
                                <div class="cont">
                                    <h4><b>Links 4G</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $IPCon ?></p>
                                <div class="cont">
                                    <h4><b>Links IPConnect</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $Radio ?></p>
                                <div class="cont">
                                    <h4><b>Links de Radio</b></h4>
                                </div>
                            </div>
                            <div class="card lj-inc">
                                <p><?= $LjInc ?></p>
                                <div class="cont">
                                    <h4><b>Lojas com Incidentes</b></h4>
                                </div>
                            </div>
                        </div>
                    </main>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                    <header>
                        <h1>Top 10 - Lojas com mais incidentes</h1>
                        <select class="form-control control-date j-ctl-per">
                            <option value="">Informe um período</option>
                            <option value="30" selected>Ultimos 30 dias</option>
                            <option value="60">Ultimos 60 dias</option>
                            <option value="90">Ultimos 90 dias</option>
                            <option value="6">Ultimos 6 meses</option>
                            <option value="12">Ultimos 12 meses</option>
                        </select>
                    </header>
                    <main>
                        <div id="piechart" style="width: 900px; height: 500px;"></div>
                    </main>
                </div>
            </div>
        </div>
<!--MODAL-->
        <div id="mdlinfo2" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Ocorrências:</h3>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
        <div id="mdlinfo3" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Lojas com Incidentes em aberto</h3>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" id="edit-table">
                            <table class="table table-striped">
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Num Loja</th>
                                        <th>Numero de Ocorrências</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($LjIncArr as $Info):
                                          echo " <tr>
                                                    <td class=\"hidden-table\" title=\"lj_end\">{$Info['o_loja']}</td>
                                                    <td title=\"lj_bairro\">{$Info['Chamados']}</td>
                                                </tr>";  
                                        endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
            <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
            <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
            <script src="<?php echo base_url('/assets/js/dashboard.js') ?>"></script>
    </body>
</html>
