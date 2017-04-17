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
        require APPPATH.'third_party/Ultilitario.php';
        $util = new Ultilitario();
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 topo">
                    <header>
                        <h1>Loja <?= $Loja['lj_num'] ?></h1>
                        <?php if($Loja['lj_sit'] == 'Fechada'):
                            echo "<p class='lj-closed'>Loja com as atividades encerradas</p>";
                        endif; ?>
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
                                                   <td class='Ip_link' rel='{$Link['cir_link']}'>{$Link['cir_ip_link']}</td>
                                                   <td><img src=" . base_url('assets/img/loading.gif') . " class='img-responsive custom-loading j-reset' id='{$Link['cir_link']}'></td>
                                                  </tr> 
                                                ";
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <!--FIM TABELAS LINKS CADASTRADOS-->
                        </div>
                        <div class="form-group col-md-3">
                            <button class="btn btn-danger j-btn-refresh">Atualizar</button>
                        </div>
                    </content>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 topo" style="margin-top: 0%; margin-bottom: 1%">
                    <header>
                        <h1>Últimas Ocorrências</h1>
                    </header>
                    <coontent>
                        <div class="table-responsive" id="edit-table">
                            <table class="table table-striped">
                                <thead class="table-custom">
                                    <tr class="tb-color">
                                        <th>Ocorrência</th>
                                        <th>Link</th>
                                        <th>Prazo de Normalização</th>
                                        <th>Aberto por</th>									
                                        <th>Emcaminhado para:</th>									
                                        <th>Situação: </th>									
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                      <?php 
                                      if(!empty($Ocorrencias)):
                                          foreach($Ocorrencias as $Ch): 
                                          
                                          switch ($Ch['o_nece']):
                                                case '2':
                                                    $Sit = 'Operadora';
                                                    break;
                                                case '3':
                                                    $Sit = 'Técnico';
                                                    break;
                                                case '4':
                                                    $Sit = 'SEMEP';
                                                    break;
                                                case '5':
                                                    $Sit = 'Falta de Energia';
                                                    break;
                                                default:
                                                    $Sit = 'Sem informações';
                                                    break;
                                            endswitch;

                                            switch ($Ch['o_sit_ch']):
                                                case '0':
                                                case '2':
                                                case '3':
                                                case '4':
                                                case '5':
                                                case '6':
                                                case '7':
                                                    $SitCh = 'Aberto';
                                                    break;
                                                case '8':
                                                    $SitCh = 'Cancelado';
                                                    break;
                                                case '1':
                                                    $SitCh = 'Fechado';
                                                    break;
                                                default :
                                                    $SitCh = 'Sem informações';
                                            endswitch;
                                          
                                          
                                          ?>
                                            <tr>
                                                <td><a href="http://sisnoc.maquinadevendas.corp/CI_SISNOC/verchamado/?Ch=<?=$Ch['o_cod']?>"><?= $Ch['o_cod'] ?></a></td>
                                                <td><?= $Ch['o_link'] ?></td>
                                                <td><?= $util->DataBR($Ch['o_prazo']) ?></td>
                                                <td><?= $Ch['o_opr_ab'] ?></td>    
                                                <td><?= $Sit ?></td>    
                                                <td><?= $SitCh ?></td> 
                                            </tr>
                                      <?php endforeach;
                                      endif;?>
                                </tbody>
                            </table>
                        </div>
                    </coontent>
                </div>
            </div>
            <div class="row "></div>
        </div>

        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/info-filiais.js') ?>"></script>
    </body>
</html>
