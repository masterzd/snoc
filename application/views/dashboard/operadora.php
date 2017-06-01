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
                            <li class="nav-item"><a href="#">Geral</a></li>
                            <li class="nav-item"><a href="#">Filas</a></li>
                        </ul>

                        <div id="#Geral">
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
                                    <p class="total-style"><?= $IPConn['lines'] + $XDSL['lines'] + $ADSL['lines'] + $MPLS['lines'] ?></p>
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
                        <div id="#Filas">
                            
                        </div>



                    </main>
                </div>
            </div>
        </div>




        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/dashboard.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/operadora.js') ?>"></script>
    </body>
</html>
