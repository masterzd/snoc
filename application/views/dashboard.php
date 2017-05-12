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
                    <img class="img-responsive logo-dash" src="<?= base_url('assets/img/SNOC3.png') ?>">
                    <ul class="nav nav-sidebar">
                        <li><a class="j-home" href="#"><i class="fa fa-home custom-ico" aria-hidden="true"> </i> <p>Home</p></a></li>
                        <li><a class="j-oper" href="#"><i class="fa fa-users custom-ico" aria-hidden="true"></i> <p>Operadora</p></a></li>
                        <li><a class="j-tec" href="#"><i class="fa fa-plug custom-ico" aria-hidden="true"></i> <p>Téc.Regionais</p></a></li>
                        <li><a class="j-semep" href="#"><i class="fa fa-wrench custom-ico" aria-hidden="true"></i> <p>SEMEP</p></a></li>
                        <li><a class="j-power" href="#"><i class="fa fa-bolt custom-ico" aria-hidden="true"></i> <p>Falta de Energia</p></a></li>
                    </ul>
                </div>
                <div class="col-md-8 area-painels">
                    <div class="col-md-8">
                        <object class="obj-panel j-obj-panel" data="<?= base_url('home') ?>" type="text/html"></object>
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
