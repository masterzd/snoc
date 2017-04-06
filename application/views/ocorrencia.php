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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css') ?>">
        <script>
            function alertaSMS() {
                alert("Não foi possível enviar sms para um ou mais destinatários.");
            }
        </script>
        <style>
            .sit{padding: 2%; margin-left: 34%;margin-bottom: -1%;}
            .custom-logo-re{position: relative;}
            .action{margin-left: 8%;font-style: italic;font-weight: 600;}
            .notas-area{background-color: #FFB900;width: 97%;padding: 1.6%;box-shadow: 1px 1px 6px -1px black;}
            .nota{width: 100%;padding: 2%;background-color: #d9534f;color: white;border-radius: 0%; border: white solid 2px; margin-top: 1%;}
            .nota:hover{background-color: #895454; cursor:pointer;}
            .nota p{text-align: center; font-weight: bold}
            .btn-add-nota{margin-left: 56%; margin-top: 5%;}
            .new-notas{margin-top: 4%;}
            .new-notas textArea{width: 127%;margin-left: 15%;}
            .notas-carregadas{width: 100%;}
        </style>
    </head>
    <body>
        <?php
//        var_dump($_SESSION);
        if (empty($_SESSION['user'])):
            header('Location:' . base_url('Start/?erro=1'));
            return false;
        endif;
        require APPPATH . 'third_party/Ultilitario.php';
        $Util = new Ultilitario();
//        var_dump($InfoCallViewCh);
        $this->load->view('commom/menu.php');

        $Necessidade = ($InfoCallViewCh['DadosCh']['o_nece'] == 2 ? 'Abertura Operadora' : ($InfoCallViewCh['DadosCh']['o_nece'] == 3 ? 'Técnico Regional' : ($InfoCallViewCh['DadosCh']['o_nece'] == 5 ? 'Normalização Local(Falta de Energia)' : ($InfoCallViewCh['DadosCh']['o_nece'] == 4 ? 'SEMEP' : ($InfoCallViewCh['DadosCh']['o_nece'] == 7 ? 'Inadiplência' : 'Outros')))));
        $SiT = ($InfoCallViewCh['DadosCh']['o_nece'] == 2 ? 'Emcaminhado Operadora' : ($InfoCallViewCh['DadosCh']['o_nece'] == 3 ? 'Emcaminhado Técnico Regional' : ($InfoCallViewCh['DadosCh']['o_nece'] == 5 ? 'Normalização Local(Falta de Energia)' : ($InfoCallViewCh['DadosCh']['o_nece'] == 4 ? 'Pendente SEMEP' : ($InfoCallViewCh['DadosCh']['o_nece'] == 7 ? 'Falta de Pagamento (Inadiplência)' : 'Cancelado')))));
        ;
        ?>

        <div class="container-fluid custom-container">

            <div class="row">
                <header class="cabecalho col-md-10 col-xs-10">
                    <h1 class="col-md-5 col-xs-10 title">Ocorrência Nº <?= $InfoCallViewCh['DadosCh']['o_cod'] ?></h1>
                    <img src="<?= base_url('assets/img/RE_Red.png') ?>" class='img-responsive col-md-3 col-xs-5 custom-logo-re' alt="LOGORE">
                    <p class="sit">Situação: <?= $SiT ?></p>
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
            <form action="http://sisnoc.maquinadevendas.corp/CI_SISNOC/update" method="POST">
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
                                <ul>
                                    <?php
                                    foreach ($InfoCallViewCh['TPAC']['prob'] as $TP):
                                        echo "<li>{$TP['ch_prob']}</li>";
                                    endforeach;
                                    ?>
                                </ul>
<!--                                <button class="btn btn-danger btn-sm btn-add j_btn"><i class="fa fa-plus" aria-hidden="true"></i></button>-->
                            </div>



                            <?php
                            if (empty($InfoCallViewCh['DadosCh']['o_prot_op']) and $InfoCallViewCh['DadosCh']['o_sit_ch'] == 2 and $_SESSION['user']['Nv'] <= 3):
                                echo "<div class='form-group'>
                                        <label class='j_des'>Protocolo Operadora:</label>
                                        <input type='text' class='form-control j_des' name='o_prot_op' required>
                                      </div>
                                      <div class='form-group'>
                                         <label class='j_des'>Prazo de Normalização</label>
                                         <input type='text' class='form-control j_des j-date-picker' name='o_prazo' placeholder='Informe aqui' required>   
                                      </div>
                                       <div class='form-group'>
                                          <label class='j_des'>Horário Chamado Operadora</label>
                                          <input type='text' class='form-control j_des j-date-picker' name='o_hr_ch_op' placeholder='Informe aqui' required>  
                                       </div>";

                                if (!empty($InfoCallViewCh['DadosCh']['o_sisman']) or ! empty($InfoCallViewCh['DadosCh']['o_otrs'])):
                                    if (!empty($InfoCallViewCh['DadosCh']['o_sisman']) and ! empty($InfoCallViewCh['DadosCh']['o_otrs'])):

                                        echo "<label>Chamado SISMAN:</label>
                                            <p class='whiteBold j_ctl_nece'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>
                                            <label>Chamado OTRS:</label>
                                            <p class='whiteBold'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>";

                                    elseif (!empty($InfoCallViewCh['DadosCh']['o_sisman'])):

                                        echo "<label>Chamado SISMAN:</label>
                                             <p class='whiteBold j_sisman'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>";

                                    elseif (!empty($InfoCallViewCh['DadosCh']['o_otrs'])):

                                        echo"<label>Chamado OTRS:</label>
                                            <p class='whiteBold j_otrs'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>";

                                    endif;
                                endif;

                            elseif (!empty($InfoCallViewCh['DadosCh']['o_prot_op'])):
                                $InfoCallViewCh['DadosCh']['o_prazo'] = DataBR($InfoCallViewCh['DadosCh']['o_prazo']);
                                $InfoCallViewCh['DadosCh']['o_hr_ch_op'] = DataBR($InfoCallViewCh['DadosCh']['o_hr_ch_op']);

                                echo "<p>Protocolo Operadora:</p>
                                <p class='whiteBold j_prot_op'>{$InfoCallViewCh['DadosCh']['o_prot_op']}</p><br>
                                <p>Prazo de Normalização</p>
                                <p class='whiteBold'>{$InfoCallViewCh['DadosCh']['o_prazo']}</p><br>
                                <p>Horário Chamado Operadora</p>
                                <p class='whiteBold'>{$InfoCallViewCh['DadosCh']}</p><br>";

                                if (!empty($InfoCallViewCh['DadosCh']['o_sisman']) or ! empty($InfoCallViewCh['DadosCh']['o_otrs'])):
                                    if (!empty($InfoCallViewCh['DadosCh']['o_sisman']) and ! empty($InfoCallViewCh['DadosCh']['o_otrs'])):

                                        echo "<label>Chamado SISMAN:</label>
                                            <p class='whiteBold j_ctl_nece'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>
                                            <label>Chamado OTRS:</label>
                                            <p class='whiteBold'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>";

                                    elseif (!empty($InfoCallViewCh['DadosCh']['o_sisman'])):

                                        echo "<label>Chamado SISMAN:</label>
                                             <p class='whiteBold j_sisman'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>";

                                    elseif (!empty($InfoCallViewCh['DadosCh']['o_otrs'])):

                                        echo"<label>Chamado OTRS:</label>
                                              <p class='whiteBold j_otrs'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>";

                                    endif;
                                endif;
                            elseif (!empty($InfoCallViewCh['DadosCh']['o_sisman'])):

                                if (!empty($InfoCallViewCh['DadosCh']['o_otrs'])):

                                    echo " <label>Chamado SISMAN:</label>
                                        <p class='whiteBold j_sisman'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>
                                        <label>Chamado OTRS:</label>
                                        <p class='whiteBold j_otrs'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>";
                                else:
                                    echo "<label>Chamado SISMAN:</label>
                                           <p class='whiteBold j_sisman'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>";
                                endif;

                            elseif ($InfoCallViewCh['DadosCh']['o_otrs']):

                                if (!empty($InfoCallViewCh['DadosCh']['o_sisman'])):
                                    echo"<label>Chamado OTRS:</label>
                                        <p class='j_otrs'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>
                                        <label>Chamado SISMAN:</label>
                                        <p class='j_sisman'>{$InfoCallViewCh['DadosCh']['o_sisman']}</p>";
                                else:
                                    echo"<label>Chamado OTRS:</label>
                                           <p class='j_otrs'>{$InfoCallViewCh['DadosCh']['o_otrs']}</p>";
                                endif;
                            endif;

                            if ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 6):
                                ?>
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
                                <?php
                            elseif ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 1):
                                echo "<p>Causa do Problema</p>";
                                echo "<p>{$InfoCallViewCh['DadosCh']['o_causa_prob']}</p>";
                                echo "</div>";
                            endif;
                            ?>

                        </div>

                        <div class="col2 col-md-3 col-xs-9 col-generic">
                            <div class="form-group">
                                <label for="Al">Momento do Alarme:</label>
                                <p><?= $Util->DataBR($InfoCallViewCh['DadosCh']['o_hr_dw']) ?></p>
                            </div>

                            <div class="form-group j_ac">
                                <label for="AC">Ação Tomada:</label>
                                <ul>
                                    <?php
                                    foreach ($InfoCallViewCh['TPAC']['acao'] as $AC):
                                        echo "<li>{$AC['ch_acao']}</li>";
                                    endforeach;

                                    if ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 1):
                                        $Result = 'SIM';
                                    else:
                                        $Result = 'Não';
                                    endif;
                                    ?>
                                </ul>

<!--                                <button class="btn btn-danger btn-sm btn-add j_btn2"><i class="fa fa-plus" aria-hidden="true"></i></button>-->
                            </div>

                            <label>Resultado da Ação:</label>

                            <div class="form-group j_action">
                                <p class="action">Loja Normalizada: <?= $Result ?></p> 
                                <p class="action">Necessidade:  <?= $Necessidade ?></p> 
                                <p class="action">Aberto por: <?= $InfoCallViewCh['DadosCh']['o_opr_ab'] . "<br>"; ?></p>    
                                <?php
                                if (!empty($InfoCallViewCh['DadosCh']['o_opr_op']) and $InfoCallViewCh['DadosCh']['o_opr_op'] != '"N"'):
                                    echo "<p class='action'>Ocorrência Tratada por: <small class='whiteBold'>{$InfoCallViewCh['DadosCh']['o_opr_op']}</small></p>";
                                endif;

                                if ($InfoCallViewCh['DadosCh']['o_sit_ch'] >= 2):
                                    echo "<p class='action' style='color:red'>Operador Atual: <b>{$_SESSION['user']['Nome']}</b></p>";
                                elseif ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 1):
                                    echo "<p>Ocorrência Fechada por: <small><b>{$InfoCallViewCh['DadosCh']['o_opr_fc']}</b></small></p>";
                                endif;

                                if ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 2 and $InfoCallViewCh['DadosCh']['o_nece'] == 2):
                                    echo "<div class='checkbox'>
                                        <label> 
                                           <input type='checkbox' name='link_norm' class='j_norm'> Link Normalizado antes de Abrir o chamado
                                        </label>   
                                        <label> 
                                          <input type='checkbox' name='link_prev' class='j_prev'> Preventiva aberta
                                        </label>   
                                    </div>";
                                endif;

                                if ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 3 or $InfoCallViewCh['DadosCh']['o_sit_ch'] == 6 or $InfoCallViewCh['DadosCh']['o_sit_ch'] == 4):
                                    if ($_SESSION['user']['Nv'] <= 2 or $_SESSION['user']['Nv'] == 4 and $InfoCallViewCh['DadosCh']['o_sit_ch'] == 3):
                                        echo "
                                                    <label>Loja Normalizada?</label>
                                                    <select name='sit' required class='form-control j_rst'>
                                                        <option value=''>Selecione ...</option>
                                                        <option value='1'>SIM</option>
                                                        <option value='2'>NÂO</option>
                                                    </select>";
                                    endif;
                                endif;
                                if ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 6 and $_SESSION['user']['Nv'] <= 2):
                                    echo "<p>Momento da Normalização:</p>";
                                    echo "<input type='text' readonly name='o_hr_up' class='form-control j-date-picker' placeholder='Informe aqui'>";
                                elseif ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 1):
                                    $InfoCallViewCh['DadosCh']['o_hr_up'] = DataBR($InfoCallViewCh['DadosCh']['o_hr_up']);
                                    echo "<p>Momento da Normalização:</p>";
                                    echo "<p>{$InfoCallViewCh['DadosCh']['o_hr_up']}</p>";
                                endif;
                                if ($InfoCallViewCh['DadosCh']['o_sit_ch'] == 6 or $InfoCallViewCh['DadosCh']['o_sit_ch'] == 1):
                                    if (!empty($InfoCallViewCh['DadosCh']['o_prot_op'])):
                                        echo "<p'>RAT do Chamado:</p>";
                                        if (empty($InfoCallViewCh['DadosCh']['o_rat'])):
                                            echo "<p  class='whiteBold'>RAT Não Encontrada!</p>";
                                            echo "<input  type='file' name='o_rat'>";
                                        elseif (!empty($InfoCallViewCh['DadosCh']['o_rat'])):
                                            echo " <a onclick=\"window.open(this.href, 'Not', 'width=825, height=525');return false;\"\  id='Not' href='rat.php?loc={$InfoCallViewCh['DadosCh']['o_rat']}'><input class='rat' type='button' value='Visualizar RAT'></a>";
                                        endif;
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>	

                    </div>
                </div>
                <div class="row">
                    <content class="col-md-11 col-xs-12 conteudo col-person">
                        <div class="col3 col-md-7 col-xs-11 col-generic ">
                            <label>Notas da Ocorrência:</label>
                            <div class="col-md-8 notas-area">
                                <div class="notas-carregadas col-md-8">
                                    <div class="ref"></div>
                                    <?php 
                                       foreach ($InfoCallViewCh['Notas'] as $N):
                                           $Dta = $Util->DataBR($N['ch_time']);
                                           echo "
                                                <div class='col-md-5 nota'>
                                                    <p>{$N['ch_user']}, no dia {$Dta} disse:</p>
                                                    <p>{$N['ch_nota']}</p>
                                                </div>
                                            ";
                                       endforeach;  
                                    ?> 
                                </div>
                                <div class="new-notas col-md-8">
                                   <textarea name="obs" rows="5" cols="100" maxlength="900" placeholder="Deixe seu comentário aqui!" class="form-control j-new-nota"></textarea>
                                   <button type="button" class="btn btn-danger btn-add-nota j-btn-nota"><i class="fa fa-plus-square" aria-hidden="true">Adicionar Nota </i></button> 
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger btn-lg btn-sm save-buttom"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;Salvar</button>
                        </div>
                    </content>
                </div>
                <input type="hidden" value="<?=$InfoCallViewCh['DadosCh']['o_cod']?>" class="ch" name='o_cod'>
            </form>	

        </div>
        <!--INPUTS PARA AUXILIAR NA INSERÇÂO DE NOTAS-->
        <input type="hidden" value="<?=$_SESSION['user']['Nome']?>" class="nome">
        <input type="hidden" value="<?= date('Y-m-d H:i:s');?>" class="hora">
        <input type="hidden" value="<?=$InfoCallViewCh['DadosCh']['o_cod']?>" class="ch">
        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/ocorrencia.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap-datetimepicker.pt-BR.js') ?>" charset="UTF-8"></script>
        <script>
            $('.j-date-picker').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language: 'pt-BR'
            });
        </script>
    </body>
</html>