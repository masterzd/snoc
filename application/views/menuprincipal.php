<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Menu Principal - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/m-principal.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>">        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css') ?>">     
    </head>
    <script>
        function Erro(mensagem) {
            alert(mensagem);
            location.href = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/menuprincipal';
        }
    </script>
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
        ?>
        <div class="container-fluid">
            <div class="row">			
                <div class="box-1 col-md-8 col-xs-8">				
                    <button class="btn btn-danger btn-menu-custom-2 btn-menu-custom j_btn-menu-custom">Abrir Ocorrência</button>

                    <div class="ab_ch">
                        <p>Abertura de Ocorrência</p>
                        <?php
                        if (!empty($erro)):
                            echo "<script>Erro('{$erro}')</script>";
                        endif;
                        ?>					
                        <form action="chamado" method="POST" class="j_newOcorr">

                            <div class="form-group col-md-2 col-xs-11">
                                <label for="nloja" class="col-sm-2 custom-label">Loja:</label>
                                <input required type="number" min="00" max="999999" name="o_loja" id="nLoja" class="form-control jnum-lj">
                            </div>

                            <div class="form-group col-md-3 col-xs-11">
                                <label for="link" class="col-sm-2 control-label">Problema:</label>
                                <select required name="o_link" id="link" class="form-control j_link">
                                    <option value="">Selecione...</option>
                                    <option value="MPLS">MPLS</option>
                                    <option value="ADSL">ADSL</option>
                                    <option value="XDSL">XDSL</option>
                                    <option value="IPConnect">IPConnect</option>
                                    <option value="Lan2Lan">Lan2Lan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3 col-xs-11">
                                <label for="stLoja" class="col-sm-2 control-label">Status Loja:</label>
                                <select required name="o_status" id="stLoja" class="form-control jStatusLoja">
                                    <option value="">Selecione...</option>
                                    <option value="MPLS">Funcionando MPLS</option>
                                    <option value="ADSL">Funcionando ADSL</option>
                                    <option value="XDSL">Funcionando XDSL</option>
                                    <option value="IPConnect">Funcionando IPConnect</option>
                                    <option value="4G">Funcionando 4G</option>
                                    <option value="Loja Offline">Loja Offline</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-xs-11">
                                <label for="alm" class="col-sm-2 control-label">Momento do Alarme:</label>
                                <input required readonly type="text" name="o_hr_dw" class="form-control jdateDown">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default btn-submit-custom">Abrir Ocorrência</button>
                            </div>

                        </form>	

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="gerador col-md-2 col-xs-8 box-2">
                    <p>Gerador de Senha</p>

                    <div class="controlpass">

                        <div class="col-md-offset-2 col-md-3">
                            <div class="checkbox">
                                <button class="btn btn-danger btn-pass j_btn-pass">Gerar</button>
                            </div>
                        </div>

                        <div class="col-md-offset-2 col-md-10">
                            <div class="checkbox">
                                <input type="text" name="resultado" class="form-control resultado j_resultado" placeholder="Resultado">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="pesquisa col-md-4 col-xs-8 box-3">
                    <p>Área de Pesquisa</p>
                    <form action="busca" method="POST" class="j_busca-Menu">

                        <div class="form-group">
                            <input type="text" name="termo" required="" title="Informe algo para eu pesquisar" class="form-control j-termo-mP" placeholder="Loja, Circuito, Ocorrência, Rua, Bairro, Cidade, UF.">

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-buscar-custom">Buscar</button>
                        </div>

                    </form>
                </div>

                <div class="pesquisa col-md-2 col-xs-8 box-4">
                    <aside>
                        <p>Eventos</p>					
                        <p>Ocorrências Abertas: <?=$abChamados?></p>
                        <a href="ocorrencias-diarias"><button class="btn btn-danger btn-ver-oc-ab">Atividades Diárias</button></a>
                        <P>Ultimas Atualizações:</P>
                        <?php
                        if (!empty($eventos)):
                            foreach ($eventos as $Eventos):
                                echo "<p class='eventos'><a href='http://sisnoc.maquinadevendas.corp/CI_SISNOC/verchamado/?Ch={$Eventos['e_chamado']}'>{$Eventos['e_nome']} {$Eventos['e_acao']}<br>";
                                echo "a ocorrência nº {$Eventos['e_chamado']} as {$Eventos['e_data']}</a></p><br>";
                            endforeach;
                        endif;
                        ?>

                    </aside>					
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/scripts.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datetimepicker.pt-BR.js') ?>" charset="UTF-8"></script>
        <script>
        $('.jdateDown').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language: 'pt-BR'
        });
        </script>
    </body>
</html>