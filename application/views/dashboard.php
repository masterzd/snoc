<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/dashboard.css') ?>">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar custom-sidedar">
                    <img class="img-responsive logo-dash" src="<?= base_url('assets/img/SNOC3.png')?>">
                    <ul class="nav nav-sidebar">
                        <li><a href="#"><i class="fa fa-home" aria-hidden="true"> </i> Home</a></li>
                        <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> Operadora</a></li>
                        <li><a href="#"><i class="fa fa-plug" aria-hidden="true"></i> Téc.Regionais</a></li>
                        <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i> SEMEP</a></li>
                        <li><a href="#"><i class="fa fa-bolt" aria-hidden="true"></i> Falta de Energia</a></li>
                    </ul>
<!--                    <ul class="nav nav-sidebar">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Operadora</a></li>
                        <li><a href="#">Infra-Estrutura</a></li>
                        <li><a href="#">SEMEP</a></li>
                        <li><a href="#">Falta de Energia</a></li>
                    </ul>-->
                </div>
            </div>            
        </div>


        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/dashboard.js') ?>"></script>
    </body>
</html>
