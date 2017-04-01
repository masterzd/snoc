<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Avisos do SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/erro.css') ?>">
        <script>
            function voltar(){
                history.back();
            }
            function menu(){
                location.href = 'Http://sisnoc.maquinadevendas.corp/CI_SISNOC/menuprincipal';
            }
        </script>
    </head>
    <body>
      <?php $this->load->view('commom/menu.php'); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="menssage-error col-md-6">
                    <img src="<?php echo base_url('assets/img/SNOC3.png') ?>" alt="SISNOC LOGO" class="img-responsive custom-nav img-error">
                    <p class="title-error">
                        <?php
                            if(!empty($Title)):
                                echo $Title;
                            elseif(!empty($Sucess)):
                                echo $Sucess;
                            endif;
                        ?>
                    </p>
                    <div class="return-message col-md-3">
                        <?php 
                            if(!empty($Msg)):
                                echo "<p>{$Msg}</p>";
                             else:
                                echo "<p>Parece que vc caiu aqui de para-quedas!!</p>";
                            endif;                        
                        ?>
                    </div>
                    <?php
                        if(!empty($Title)):
                            echo "<button class=\"btn btn-default btn-warning btn-erro\" onclick=\"Javascript:voltar()\">Voltar</button>";
                        elseif(!empty($Sucess)):
                            echo "<button class=\"btn btn-default btn-warning btn-erro\" onclick=\"Javascript:menu()\">Menu Principal</button>";
                        endif;
                    ?>
                </div>                
            </div>            
        </div>        
        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/scripts.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
    </body>
</html>
