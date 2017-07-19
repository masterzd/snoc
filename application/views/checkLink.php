<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/vis-link.css') ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <title>Lista de Links - SISNOC</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="space col-md-5">
                    <h1>Links da Loja <?= $Dados[0]['cir_loja']; ?></h1>
                    <div class="navbar navbar-default navbar-custom">
                        <input type="hidden" name="cir_loja" id="loja" value="<?= $Dados[0]['cir_loja'] ?>">
                        <?php
                        $id = 1;
                        
                    if(!empty($Dados[0]['cir_cod'])):
                  
                        foreach ($Dados as $Link):
                            ?>

                            <div class="container-fluid form-horizontal" id="<?= $id ?>">
                                <div class="form-group col-md-2 col-xs-2 custom-div-link">
                                    <label for="link" class="col-md-2 control-label">Link</label>
                                    <input type="text" disabled value="<?= $Link['cir_link'] ?>" name="" id="link" class="form-control input-sm j_edit-link-loja bkg">
                                    <input type="hidden" name="cir_cod" id="cod" value="<?= $Link['cir_cod'] ?>">
                                </div>
                                <div class="form-group col-md-2 col-xs-2 custom-div-link">
                                    <label for="opr" class="col-md-2 control-label">Operadora</label>
                                    <input type="text" disabled  value="<?= $Link['cir_oper'] ?>" name="" id="opr" class="form-control input-sm j_edit-link-loja bkg">

                                </div>
                                <div class="form-group col-md-2 col-xs-3 custom-div-link">
                                    <label for="cir" class="col-md-2 control-label">Circuito</label>
                                    <input type="text" disabled  value="<?= $Link['cir_desig'] ?>" name="" id="cir" class="form-control input-sm j_edit-link-loja bkg">
                                </div>
                                <div class="form-group col-md-2 col-xs-3 custom-div-link">
                                    <label for="ip" class="col-md-2 control-label">IP Mon.</label>
                                    <input type="text" disabled value="<?= $Link['cir_ip_link'] ?>" name="" id="ip" class="form-control input-sm j_edit-link-loja bkg">
                                </div>
                                <div class="form-group col-md-2 col-xs-3 custom-div-link">
                                    <label for="ip" class="col-md-2 control-label">IP Lan Router</label>
                                    <input type="text" disabled value="<?= $Link['cir_ip_lan_router'] ?>" name="" id="ip-lan" class="form-control input-sm j_edit-link-loja bkg">
                                </div>
                                <div class="form-group col-md-2 col-xs-2 custom-div-link">
                                    <label for="vel" class="col-md-2 control-label">Banda</label>
                                    <input type="text" disabled value="<?= $Link['cir_band'] ?>" name="" id="vel" class="form-control input-sm j_edit-link-loja bkg">
                                </div>
                                <div class="btn-area">
                                    <button  class="btn btn-warning btn-custom j-edit-link" id="<?= $id ?>" data-toogle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                    <button id="<?= $id ?>" class="btn btn-primary btn-custom j-save-link" data-toogle="tooltip" data-placement="top" title="Salvar"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    <button id="<?= $id ?>" class="btn btn-danger btn-custom j-del-link" ><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                </div>	
                            </div>

                            <?php
                            $id++;
                        endforeach;
                    else:
                        echo "<p>Não existe links cadastrados.</p>";
                    endif;
                        ?>
                    </div>
                    <div class="action-area">
                        <button class="btn btn-danger j_add_link">Adicionar Link</button><button class="btn btn-danger j_close_link">Fechar</button>
                    </div>
                    <div id="modalDeletelink" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header custom-modal">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="modal-title">SISNOC Pergunta:</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que deseja apagar o Link?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger j_btn-lnk-rm-yes" data-dismiss="modal">SIM</button>
                                    <button type="button" class="btn btn-default j_btn-lnk-rm-no" data-dismiss="modal">NAO</button>
                                </div>
                            </div>
                        </div>
                    </div>	

                </div>
                <div id="modalDeletelink-2" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header custom-modal">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">SISNOC Pergunta:</h3>
                            </div>
                            <div class="modal-body">
                                <p>Falha ao remover os dados. Entre em contato com o suporte.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger j_btn-lnk-rm-yes" data-dismiss="modal">OK</button>
                            </div>
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