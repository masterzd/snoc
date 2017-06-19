<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/cad-link.css') ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <title>Cadastro de Links - SISNOC</title>
    </head>
    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="contorno col-md-5">
                    <div class="title">
                        <h2>Cadastro de Links</h2>
                    </div>				
                    <form action="" method="POST" class="j_cad_link">
                        <content class="col-xs-12 control-form">

                            <div class="form-group col-xs-6">
                                <label for="Link">Link:</label>
                                <select name="cir_link" id="link" class="form-control j_link-loja j_loja_clear" required>
                                    <option value="">Selecione...</option>
                                    <option value="MPLS">MPLS</option>
                                    <option value="ADSL">ADSL</option>
                                    <option value="XDSL">XDSL</option>
                                    <option value="IPConnect">IPConnect</option>
                                    <option value="4G">4G</option>
                                    <option value="Radio">Radio</option>
                                </select>
                            </div>

                            <div class="form-group col-xs-6">
                                <label for="desig">Designação:</label>
                                <input type="text" name="cir_desig" class="form-control j_desig-loja j_loja_clear" id="desig" required>
                            </div>

                            <div class="form-group col-xs-6">
                                <label for="oper">Operadora:</label>
                                <input type="text" name="cir_oper" class="form-control j_oper-loja j_loja_clear" id="oper" required>
                            </div>

                            <div class="form-group col-xs-6">
                                <label for="ip">IP de Monitoramento:</label>
                                <input type="text" name="cir_ip_link" class="form-control j_ip-loja j_loja_clear" id="ip" required>
                            </div>

                            <div class="form-group col-xs-6">
                                <label for="band">Banda:</label>
                                <input type="text" name="cir_band" class="form-control j_ip-loja j_loja_clear" id="band" required>
                            </div>

                            <div class="form-group col-xs-6 btn-save-loja">
                                <button class="btn btn-default j_salvar-loja"><i class="fa fa-floppy-o" aria-hidden="true">Salvar</i></button>
                            </div>


                        </content>
                    </form>

                </div>

                <div id="mdcadinfo" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header custom-modal">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">SISNOC Informa:</h3>
                            </div>
                            <div class="modal-body">
                                <p>Falha ao Inserir os dados. Procure o suporte.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="mdcadinfo2" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header custom-modal">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">SISNOC Informa:</h3>
                            </div>
                            <div class="modal-body">
                                <p>Dados Inseridos com sucesso. Gostaria de cadastrar outro Link?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger j_btn-lj-lk-yes" data-dismiss="modal">SIM</button>
                                <button type="button" class="btn btn-default j_btn-lj-lk-no" data-dismiss="modal">NAO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/scripts.js') ?>"></script>
    </body>
</html>