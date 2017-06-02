<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/dashboard/operadora.css') ?>">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <title>Dashboard - Operadora</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <header>
                        <h1>DashBoard - Ocorrências Abertas Operadora</h1>
                    </header>
                    <main>
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="#" id="Geral">Geral</a></li>
                            <li class="nav-item"><a href="#" id="Filas">Filas</a></li>
                        </ul>

                        <div class="Geral">
                            <div class="ctl-card">
                                <div class="card">
                                    <p id="0"><?= $MPLS['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>MPLS</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="1"><?= $ADSL['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>ADSL</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="2"><?= $XDSL['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>XDSL</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="3"><?= $Radio['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>Radio</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="4"><?= $IPConn['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>IPConnect</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="7" class="total-style"><?= $IPConn['lines'] + $XDSL['lines'] + $ADSL['lines'] + $MPLS['lines'] ?></p>
                                    <div class="cont">
                                        <h4><b>Total</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="5"><?= $Prev['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>Preventivas</b></h4>
                                    </div>
                                </div>
                                <div class="card">
                                    <p id="6"><?= $Inad['lines'] ?? 0 ?></p>
                                    <div class="cont">
                                        <h4><b>Inadiplência</b></h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="Filas hidden">
                            <div class="ctl-card">
                                <div class="card card-large">
                                    <div class="cont">
                                        <h4><b>Direcionadas para a operadora</b></h4>
                                    </div>
                                    <div class="col-md-12 col-xs-12 table-tam">
                                        <p class="title-filas">Ocorrências com mais de 15 Min (MPLS - XDSL - IPConnect)</p>
                                        <div class="table-responsive">
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
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12 col-xs-12 table-tam">
                                        <p class="title-filas">ADSL - Acima de 1 Hora</p>
                                        <div class="table-responsive">
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
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-large">                                    
                                    <div class="cont">
                                        <h4><b>Ocorrências com prazo de normalização expirado</b></h4>
                                    </div>
                                    <div class="col-md-12 col-xs-12 table-tam">
                                        <p class="title-filas">MPLS - XDSL - IPConnect</p>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead class="table-custom">
                                                    <tr class="tb-color">
                                                        <th>Num. Ocor</th>
                                                        <th>Loja</th>
                                                        <th>Link</th>
                                                        <th>Operadora</th>
                                                        <th>Prazo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                    <div class="col-md-12 col-xs-12 table-tam">
                                        <p class="title-filas">Link de Backup</p>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead class="table-custom">
                                                    <tr class="tb-color">
                                                        <th>Num. Ocor</th>
                                                        <th>Loja</th>
                                                        <th>Link</th>
                                                        <th>Operadora</th>
                                                        <th>Prazo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <div id="Modal" class="modal fade" role="dialog"></div>



        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/dashboard.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/operadora.js') ?>"></script>
    </body>
</html>
