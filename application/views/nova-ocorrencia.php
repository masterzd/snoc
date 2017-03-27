<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Nova Ocorrência - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/chamado.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script>
            function alertaSMS(){
                alert("Não foi possível enviar sms para um ou mais destinatários.");
            }
        </script>
    </head>
    <body>
        <?php
        if($InfoCallViewCh['SMS'] == false):
            echo "<script>alertaSms()</script>";
        endif;
        require APPPATH . 'third_party/Ultilitarios.php';
        $this->load->view('commom/menu.php')
        ?>

        <div class="container-fluid custom-container">

            <div class="row">
                <header class="cabecalho col-md-10 col-xs-10">
                    <h1 class="col-md-5 col-xs-10 title">Ocorrência Nº <?= $InfoCallViewCh['DadosCh']['o_cod'] ?></h1>
                    <img src="<?= base_url('assets/img/RE_Red.png') ?>" class='img-responsive col-md-3 col-xs-5 custom-logo-re' alt="LOGORE">									
                </header>
            </div>

            <div class="row">
                <content class="col-md-11 col-xs-11 conteudo">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption>Informações da Loja</caption>
                            <thead class="table-custom">
                                <tr class="tb-color">
                                    <th>Loja</th>
                                    <th>Bairro</th>
                                    <th>Cidade</th>
                                    <th>Estado</th>								
                                    <th class="hidden-table">Tipo de Loja</th>
                                    <th class="hidden-table">Ramal</th>								
                                    <th class="hidden-table">Tel. Fixo</th>	
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_num'] ?></td>
                                    <td><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_bairro'] ?></td>
                                    <td><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_cidade'] ?></td>
                                    <td><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_uf'] ?></td>
                                    <td class="hidden-table"><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_tipo'] ?></td>
                                    <td class="hidden-table"><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_tel_ram'] ?></td>								
                                    <td class="hidden-table"><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_tel_fix'] ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-striped">
                            <thead>
                                <tr class="tb-color">
                                    <th>Gerente</th>
                                    <th>Corporativo Gerente</th>
                                    <th class="hidden-table">Gerente Regional</th>
                                    <th class="hidden-table">Corporativo Regional</th>
                                    <th class="hidden-table">Resp. Técnico</th>
                                    <th class="hidden-table">Corporativo Técnico:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>								
                                    <td><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_ger'] ?></td>
                                    <td><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_tel_ger'] ?></td>
                                    <td class="hidden-table"><?= $InfoCallViewCh['DadosLoja']['Loja']['GerRegName'] ?></td>
                                    <td class="hidden-table"><?= $InfoCallViewCh['Contatos']['GerReg'] ?></td>
                                    <td class="hidden-table"><?= $InfoCallViewCh['DadosLoja']['Loja']['lj_resp_tec']['resp_nome'] ?></td>
                                    <td class="hidden-table"> <?= $InfoCallViewCh['DadosLoja']['Loja']['lj_resp_tec']['resp_corp'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>					
                </content>			
            </div>


            <div class="row">
                <content class="col-md-11 col-xs-11 conteudo">
                    <h3>Conectividade</h3>					
                    <?php
                    $i = 1;
                    foreach ($InfoCallViewCh['DadosLoja']['Links'] as $Link):
                        echo "
                        <div class='links col-md-2 col-xs-4 j_link{$i}' data-toggle='popover' title='Link:{$Link['cir_link']}' data-content='Verificando...' data-placement='bottom'>
                                <img src=" . base_url('assets/img/loading.gif') . " class='img-responsive custom-loading jImgLoad{$i}'>
                                <p>{$Link['cir_link']}</p>
                                <p>{$Link['cir_desig']}</p>
                                <p>{$Link['cir_ip_link']}</p>
                        </div>";

                        if ($i < 3):
                            $i++;
                        else:
                            break;
                        endif;
                    endforeach;
                    ?>							

                    <div class="col-md-2 action-buttons col-xs-2">
                        <button class="btn btn-danger jrefresh" data-toogle="tooltip" data-placement="top" title="Checar Status do Link"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                        <button class="btn btn-danger btn-more-info" data-toogle="tooltip" data-placement="top" title="Mais Informações"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    </div>	

                </content>				
            </div>         
            <form action="save" method="POST">
                <div class="row">					
                    <div class="col-md-11 col-xs-11 conteudo">

                        <h3>Dados da Ocorrência</h3>
                        <div class="col1 col-md-3 col-xs-9 col-generic">
                            <div class="form-group">
                                <label for="Prob">Link Alarmado:</label>
                                <p><?= $InfoCallViewCh['DadosCh']['o_link'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for="St">Status Loja:</label>
                                <p><?= $InfoCallViewCh['DadosCh']['o_status'] ?></p>
                            </div>
                            <div class="form-group j_tp">
                                <label for="St">Tipo de Problema:</label>
                                <select name="tp_desc[]" required class="form-control j_control j_select" id="St">
                                    <option value="">Selecione...</option>
                                    <?php
                                    foreach ($InfoCallViewCh['DadosCh']['tp'] as $TP):
                                        echo "<option value='{$TP['tp_desc']}'>{$TP['tp_desc']}</option>";
                                    endforeach;
                                    ?>
                                </select>
                                <button class="btn btn-danger btn-sm btn-add j_btn"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                            <div class="form-group">
                                <label for="Cp">Causa do Problema:</label>
                                <select name="o_causa_prob" disabled class="form-control j_cp">
                                    <option value="">Selecione...</option>
                                    <optgroup label="Infra-Estrutura (Loja)">
                                        <option value="INT_Alta_ultilização">Alta Ultilização</option>
                                        <option value="INT_Cabeamento">Cabeamento</option>
                                        <option value="INT_Conf_Roteador">Conf. Roteador</option>
                                        <option value="INT_Climatização">Climatização</option>
                                        <option value="INT_Equipamento_Desligado">Equipamento Desligado</option>
                                        <option value="INT_Falta_Energia">Falta de Energia (Interno)</option>
                                        <option value="INT_Falha_Massiva">Falha Massiva(Ex: L3 down)</option>
                                        <option value="INT_Falha_Roteador">Falha no Roteador</option>
                                        <option value="INT_Falha_Swicth">Falha no Switch</option>
                                        <option value="INT_Falha_Nobreak">Falha no Nobreak</option>
                                        <option value="INT_Falha_Eletrica">Falha Elétrica (Interno)</option>
                                        <option value="INT_Feriado">Feriado (Local ou Nacional)</option>
                                        <option value="INT_Inadimplência">Inadimplência (Fatura em atraso)</option>
                                        <option value="INT_Incrementando_CRC">Incrementando CRC</option>
                                        <option value="INT_Sinistro">Sinistro(Roubo, Incêncio)</option>
                                        <option value="INT_Rack_Desligado">Rack Desligado</option>
                                        <option value="INT_Sem_Expediente">Sem Expediente</option>
                                        <option value="INT_Upgrade_Mudança_link_Estr_Fisica">Upgrade / Mudança de link / Estrutura fisica  </option>
                                    </optgroup>                                    
                                    <optgroup label="Operadora">
                                        <option value="OP_BGP/Rota">BGP/Rota</option>
                                        <option value="OP_Cabeamento">Cabeamento</option>
                                        <option value="OP_Velocidade_abaixo_contratado"> Banda Insuficiente (Vel. abaixo)</option>
                                        <option value="OP_Evento_Vulto_Massiva">Evento de Vulto / Massiva</option>
                                        <option value="OP_Falta_de_Energia">Falta de Energia (Operadora)</option>
                                        <option value="OP_Falha_no_Roteador">Falha Roteador (Operadora)</option>
                                        <option value="OP_Imcrementando CRC">Imcrementando CRC</option>
                                        <option value="OP_Intermitência">Intermitência</option>
                                        <option value="OP_Latência_Alta">Latência Alta</option>
                                        <option value="OP_Proativo_Indevido">Proativo Indevido</option>
                                        <option value="OP_Perda_de_Pacotes">Perda de Pacotes</option>
                                        <option value="OP_Preventiva">Preventiva</option> 
                                        <option value="OP_Rompimento de Fibra">Rompimento de Fibra</option>
                                        <option value="OP_Sinistro">Sinistro (Roubo de Cabos etc.)</option>
                                        <option value="OP_Sem_Intervencao_Tecnica">Sem Intervenção Técnica</option>
                                        <option value="OP_Upgrade_Mudança_link_Estr_Fisica">Upgrade / Mudança de link / Estrutura fisica</option>                                     
                                    </optgroup>
                                    <optgroup label="Terceiros (Concessionária de Energia)">
                                        <option value="CO_Falta_de_Energia">Falta de Energia (Concessionária)</option>
                                        <option value="CO_Falha Estrutural">Falha Estrutural</option>
                                        <option value="CO_Fenomenos_Naturais">Fenômenos Naturais</option>
                                        <option value="CO_Variacao_Eletrica">Variação Elétrica</option>
                                    </optgroup>                                   
                                    <optgroup label="Abertura Indevida">
                                        <option value="INT_Cancelamento">Cancelamento (Interno)</option>
                                        <option value="OP_Cancelamento">Cancelamento (Operadora)</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col2 col-md-3 col-xs-9 col-generic">
                            <div class="form-group">
                                <label for="Al">Momento do Alarme:</label>
                                <p><?= DataBR($InfoCallViewCh['DadosCh']['o_hr_dw']) ?></p>
                            </div>

                            <div class="form-group j_ac">
                                <label for="AC">Ação Tomada:</label>
                                <select required name="ac_desc[]" class="form-control j_control2 j_select2" id="AC">
                                    <option value="">Selecione...</option>
                                    <?php
                                    foreach ($InfoCallViewCh['DadosCh']['ac'] as $AC):
                                        echo "<option value='{$AC['ac_desc']}'>{$AC['ac_desc']}</option>";
                                    endforeach;
                                    ?>
                                </select>
                                <button class="btn btn-danger btn-sm btn-add j_btn2"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>

                            <p>Resultado da Ação:</p>

                            <div class="form-group j_action">
                                <label for="Ln">Loja Normalizada?</label>
                                <select required name="sit" class="form-control j_rst" id="Ln">
                                    <option value="">Selecione...</option>
                                    <option value="1">SIM</option>
                                    <option value="2">NAO</option>
                                </select>
                            </div>
                        </div>	

                    </div>
                </div>
                <!--DADOS PARA SEREM TRANSFERIDOS PARA A ETAPA DE GRAVAÇÂO DA OCORRÊNCIA-->
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                <div class="row">
                    <content class="col-md-11 col-xs-12 conteudo col-person">
                        <div class="col3 col-md-7 col-xs-11 col-generic ">
                            <p>Observações</p>
                            <textarea name="obs" rows="10" cols="100" maxlength="900" placeholder="Deixe seu comentário aqui!" class="form-control"></textarea>
                            <button type="submit" class="btn btn-danger btn-lg btn-sm save-buttom"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;Salvar</button>
                        </div>
                    </content>
                </div>
            </form>	

        </div>

        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/ocorrencia.js') ?>"></script>
    </body>
</html>