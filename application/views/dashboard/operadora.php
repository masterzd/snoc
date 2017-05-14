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
                        <div class="ctl-card">
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Abertos MPLS</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Abertos ADSL</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Abertos XDSL</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Abertos IPConnect</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Total</b></h4>
                                </div>
                            </div>
                            <div class="card">
                                <p><?= $CadLj ?></p>
                                <div class="cont">
                                    <h4><b>Preventivas</b></h4>
                                </div>
                            </div>
                            
                        </div>
                        
                    </main>
                </div>
            </div>
        </div>
        
        
        

        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/dashboard.js') ?>"></script>
    </body>
</html>
