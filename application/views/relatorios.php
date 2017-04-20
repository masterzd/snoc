<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Relatórios - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/relatorio.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css') ?>">
    </head>
    <body>
        <?php
        session_start();
        $this->load->view('commom/menu.php');
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-6 block-rel">
                    <p class="title">Informe abaixo o tipo de relatório a ser gerado:</p>
                    <form class="j-form-rel form-inline" method="POST" action="">
                        <select required title="Informe uma opção de relatório" class="form-control j-sel-rel">
                            <option value="">Selecione...</option>
                            <option value="1">Geral - PDF</option>
                            <option value="2">SMS Enviados - PDF</option>
                            <option value="3">Por Loja - PDF</option>
                            <option value="4">Disponibilidade x Interrupções</option>
                            <option value="5">Produtividade NOC</option>
                        </select>
                        <p>Informe o período:</p>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" placeholder="Informe a data inicial" class="j-date input-sm form-control col-md-2" name="dataIni">
                            <span class="input-group-addon">a</span>
                            <input type="text" placeholder="Informe a data final" class="j-date input-sm form-control col-md-2" name="dataFim">
                        </div>
                        <div class="j-add-el"></div>
                        <button class="btn btn-danger">Gerar</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datepicker.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datepicker.pt-BR.min.js') ?>" charset="UTF-8"></script>
        <script src="<?php echo base_url('/assets/js/relatorio.js') ?>" charset="UTF-8"></script>
        <script>
            $('.j-date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'pt-BR',
                orientation: 'bottom auto',
                autoclose: true
            });
        </script>
    </body>
</html>
