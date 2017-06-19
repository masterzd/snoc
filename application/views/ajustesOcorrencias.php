<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ajustes de Ocorrências - SISNOC</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/ajustesOco.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css') ?>"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 conteudo">
                    <input type="hidden" value="<?=$Dados[0]['o_cod']?>" name="ocorrencia" class="ocorrencia">
                    <p>Ocorrência <?=$Dados[0]['o_cod']?> encontrada. O que você deseja alterar?</p>
                    <div class="form-group col-md-3 col-xs-11">
                        <select required name="o_link" id="link" class="form-control j_link">
                            <option value="">Selecione...</option>
                            <option value="1">Link</option>
                            <option value="2">Designação</option>
                            <option value="3">Situação da Ocorrência</option>
                            <option value="4">Prazo de Normalização</option>
                            <option value="5">Hora do Incidente</option>
                            <option value="6">Protocolo Operadora</option>
                            <option value="7">Status da Ocorrência</option>
                            <option value="8">Necessidade (Emcaminhado)</option>
                        </select>
                    </div>
                </div>
                <div class="j-ajustes">
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-default btn-submit-custom j-sv">Salvar</button>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/ajustesOcorr.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datetimepicker.pt-BR.js') ?>" charset="UTF-8"></script>
    </body>
</html>
