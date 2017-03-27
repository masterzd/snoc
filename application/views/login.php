<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Bem Vindo ao SISNOC</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/login.css') ?>">
    <body>
        <div class="container">		
            <div class="row">
                <div class="login col-md-7 col-xs-7">
                    <header>
                        <img src="<?php echo base_url('/assets/img/SNOC4.png') ?>" class="img-responsive" alt="SISNOC LOGO" title="SISNOC LOGO">
                    </header>					
                    <content>
                        <form action="validacao" method="POST" name="login-form" class="form-inline">

                            <?php
                            if (!empty($erro)):
                            echo"
                            <div class='alert alert-danger'>
                                    {$erro}
                            </div>
                            ";
                            elseif (!empty($_GET['erro'] == 1)):
                                echo"
                                <div class='alert alert-danger'>
                                        Sessão Expirada. Favor Fazer o login Novamente.
                                </div>";
                            endif;
                            ?>
                            <div class="form-group">
                                <label for="user">Login:</label>
                                <input class="form-control" type="text" name="u_user" id="user">
                            </div>
                            <div class="form-group">
                                <label for="pass">Senha:</label>
                                <input class="form-control" type="password" name="u_senha" id="pass">
                            </div>

                            <button type="submit" class="btn btn-danger btn-custom">Entrar</button>
                        </form>
                    </content>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/scripts.js') ?>"></script>
    </body>
</html>