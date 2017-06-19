<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel de Administração - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/adm.css') ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-switch.min.css') ?>"> 
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body>
        <?php
        session_start();
        if (empty($_SESSION['user'])):
            $Validation['erro'] = "Sessão Expirada. Fazer login novamente.";
            $this->load->view('login', $Validation);
            die();
        endif;
        if (!empty($_SESSION['InfoCallViewCh']) or ! empty($_SESSION['CtlCh'])):
            unset($_SESSION['InfoCallViewCh'], $_SESSION['CtlCh']);
        endif;
        $this->load->view('commom/menu.php');
        
        if($Dados[0]['c_sms'] == 'S'):
            $Checked1 = 'checked';
        else:
            $Checked1 = '';
        endif;
        
        if($Dados[0]['c_email'] == 'S'):
            $Checked2 = 'checked';
        else:
            $Checked2 = '';
        endif;
        
        
        ?>       
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 conteudo">
                    <header>
                        <h1>Painel de configurações do SISNOC</h1>
                    </header>
                    <main>
                        <div class="card card-large">
                            
                            <div class="cont">
                                <h4><b>SMS e E-mail</b></h4>
                            </div>
                            
                            <div class="area-buttons">
                                <input type="checkbox" name="sms" class="j-sms" <?= $Checked1?>> SMS
                                <input type="checkbox" name="sms" class="j-mail" <?= $Checked2?>> E-mail
                            </div>
                        </div>
                        <div class="card card-large-p">
                            
                            <div class="cont">
                                <h4><b>Ajustes de Ocorrências</b></h4>
                            </div>
                            
                            <div class="area-buttons">
                                <p>Informe o numero da ocorrência</p>
                                <input type="number" class="form-control j-num">
                                <button type="button" class="btn btn-default j-busca-o"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-switch.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/adm.js') ?>"></script>
    </body>
</html>
