<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Informações Loja <?= $Loja['lj_num'] ?> - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/filial.css') ?>"> 
    </head>
    <body>
        <?php
        session_start();
        $this->load->view('commom/menu.php');
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 topo">
                    <header>
                        <h1>Loja <?= $Loja['lj_num'] ?></h1>
                    </header>
                    <content>
                        <div class="table-responsive" id="edit-table">
                         <!--TABELAS DE LOCALIZAÇAO-->
                            <table class="table table-striped">
                                <caption>Localização:</caption>
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Endereço</th>
                                        <th>Bairro</th>
                                        <th>Cidade</th>
                                        <th>Estado</th>									
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td title="lj_end"><?= $Loja['lj_end'] ?></td>
                                        <td title="lj_bairro"><?= $Loja['lj_bairro'] ?></td>
                                        <td title="lj_cidade"><?= $Loja['lj_cidade'] ?></td>
                                        <td title="lj_uf"><?= $Loja['lj_uf'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped" id="edit-table">
                                <thead class="table-custom">
                                    <tr class="tb-color">								
                                        <th class="hidden-table">Tipo de Loja</th>
                                        <th class="hidden-table">Ramal</th>								
                                        <th class="hidden-table">Tel. Fixo</th>	
                                        <th class="hidden-table">Regional:</th>	
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td title="lj_tipo" class="hidden-table"><?= $Loja['lj_tipo'] ?></td>								
                                        <td title="lj_tel_ram" class="hidden-table"><?= $Loja['lj_tel_ram'] ?></td>
                                        <td title="lj_tel_fix" class="hidden-table"><?= $Loja['lj_tel_fix'] ?></td>
                                        <td title="r_cod" class="hidden-table"><?= $Loja['r_cod'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                         <!--FIM TABELAS LOCALIZAÇÂO-->
                         <!--TABELAS RESPONSAVEIS LOJA-->
                            <table class="table table-striped" id="edit-table">
                                <caption>Responsáveis da Loja:</caption>
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Gerente</th>
                                        <th>Corp. Gerente</th>
                                        <th>Gerente Regional</th>
                                        <th>Corp Ger. Regional</th>								                                     								                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td title="lj_ger"><?= $Loja['lj_ger'] ?></td>
                                        <td title="lj_tel_ger"><?= $Loja['lj_tel_ger'] ?></td>
                                        <td></td>
                                        <td><?= $Resp['GerReg'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped" id="edit-table">
                                <thead class="table-custom">
                                    <tr class="tb-color">							                                     
                                        <th>Diretor Regional</th>
                                        <th>Corp Dir. Regional</th>								                                     
                                        <th>Resp. Técnico</th>
                                        <th>Corp. Res. Técnico</th>								                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><?= $Resp['DirReg'] ?></td>
                                        <td><?= $Loja['lj_resp_tec']['resp_nome'] ?></td>
                                        <td><?= $Loja['lj_resp_tec']['resp_corp'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                         <!--FIM RESPONSÀVEIS LOJA-->
                         <!--TABELAS LINKS CADASTRADOS-->
                            <table class="table table-striped">
                                <caption>Links cadastrados:</caption>
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Link</th>
                                        <th>Circuito</th>
                                        <th>Operadora</th>
                                        <th>Banda</th>
                                        <th>Ip de monitoramento:</th>								                                     
                                        <th>Status:</th>								                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($Links as $Link):  
                                          echo " 
                                                  <tr>
                                                   <td>{$Link['cir_link']}</td>
                                                   <td>{$Link['cir_desig']}</td>
                                                   <td>{$Link['cir_oper']}</td>
                                                   <td>{$Link['cir_band']}</td>
                                                   <td class='Ip_link'>{$Link['cir_ip_link']}</td>
                                                   <td><img src=" . base_url('assets/img/loading.gif') . " class='img-responsive custom-loading switch'></td>
                                                  </tr> 
                                                ";
                                        endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <!--FIM TABELAS LINKS CADASTRADOS-->
                        </div>
                    </content>
                </div>
            </div>
            <div class="row">
                
            </div>
            <div class="row"></div>
        </div>

        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/info-filiais.js') ?>"></script>
    </body>
</html>
