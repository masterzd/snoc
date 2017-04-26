<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Gerenciamento - SISNOC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/manager.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body>
        <?php
        session_start();
        if (empty($_SESSION['user'])):
            $Validation['erro'] = "Sessão Expirada. Fazer login novamente.";
            $this->load->view('login', $Validation);
        endif;

        $this->load->view('commom/menu.php')
        ?>		
        <div class="container-fluid">		
            <div class="row">
                <div class="m-space col-md-12">					
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="j_usuario"><a href="#">Usuários</a></li>
                        <li role="presentation" class="j_loja"><a href="#">Lojas</a></li>
                        <li role="presentation" class="j_gtd"><a href="#">Info. Regionais</a></li>
                    </ul>
                    <div class="box box-users col-md-11">						
                        <h4>Gestão de Usuários</h4>
                        <div class="busca-user">	
                            <div class="search col-md-4">						
                                <form action="" method="post" class="j_search">
                                    <p>Informe o usuário</p>
                                    <input type="text" name="u_user " class="form-control col-sm-2 j_termo-user">
                                    <button class="btn btn-default btn-search j_search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>						
                            </div>
                            <div class="card-users col-md-12">								

                            </div>


                            <div id="modalDelete" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header custom-modal">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3 class="modal-title">SISNOC Pergunta:</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja apagar o usuário?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger j_btn-yes" data-dismiss="modal">SIM</button>
                                            <button type="button" class="btn btn-default j_btn-no" data-dismiss="modal">NAO</button>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>

                        <div class="new-user hide-manager">
                            <div class="new col-md-4">
                                <p class="new-title">Informe os dados do novo usuário</p>
                            </div>

                            <form action="" method="POST" class="j_new_user">
                                <div class="col-md-8 control-form">
                                    <div class="form-group col-md-5 control-edit">
                                        <label for="name">Nome</label>
                                        <input type="text" name="u_nome" class="form-control j_name j_user_clear" id="name" required title="Informe o nome do usuário.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="funcao">Função</label>
                                        <input type="text" name="u_funcao" class="form-control j_funcao j_user_clear" id="funcao" required title="Informe a função.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="email">Email</label>
                                        <input type="email" name="u_email" class="form-control j_email j_user_clear" id="email" required title="informe um e-mail válido.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="tel">Telefone</label>
                                        <input type="tel" name="u_tel" pattern="^[0-9]{11}$" class="form-control j_tel j_user_clear" id="tel" required title="Informe o numero de telefone.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="user">Nome de Usuário</label>
                                        <input type="text" name="u_user" class="form-control j_user_name j_user_clear" id="user" required title="Informe o nome de usuário.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="pass">Informe a senha</label>
                                        <input type="password" pattern="^[A-Z][a-z0-9]{7,}" name="u_senha"  class="form-control j_pass j_user_clear" id="pass" required title="A senha precisa ter no minimo 8 caracteres sendo que o primeiro caractere deve ser Maiúscula e os restante minúscula ou números.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="pass2">Repita a senha</label>
                                        <input type="password" pattern="^[A-Z][a-z0-9]{7,}" name="u_senha2" class="form-control j_pass2 j_user_clear" id="pass2" required title="A senha precisa ter no minimo 8 caracteres sendo que o primeiro caractere deve ser Maiúscula e os restante minúscula ou números.">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="active">Ativar Conta?</label>
                                        <select name="u_ativo" class="form-control j_ativate j_user_clear" id="active" required title="A conta será ativa?">
                                            <option value="">Selecione...</option>
                                            <option value="1">SIM</option>
                                            <option value="2">NAO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="nivel">Nível de Acesso:</label>
                                        <select name="u_nivel_acesso" class="form-control j_nivel j_user_clear" id="nivel" required title="Informe o nível de acesso.">
                                            <option value="">Selecione...</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Operador NOC</option>
                                            <option value="3">Residente Operadora</option>
                                            <option value="4">Técnico Regional</option>
                                            <option value="5">Gerente Loja</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <button class="btn btn-default btn-save-user j_save-user"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </div>
                                </div>	
                            </form>

                        </div>	
                        <div class="opt col-md-5 j_add">
                            <button class="btn btn-default btn-new-user j_btn-new-user j_btn-new"><i class="fa fa-plus-circle" aria-hidden="true"> Novo</i></button>
                        </div>					
                    </div>

                    <div class="box box-lojas hide-manager col-md-9">
                        <div class="search-loja j_search-loja">						
                            <div class="search-lj col-md-7">
                                <form action="" method="post" class="">
                                    <p>Informe o número da loja.</p>
                                    <input type="number" name="lj_num" class="form-control col-sm-2 j_termo-loja">
                                    <button class="btn btn-default btn-search j_search-submit-loja"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>	
                            </div>
                            <div class="card-area-lojas col-md-12">								

                            </div>					
                        </div>

                        <div class="new-loja hide-manager">
<!--                            <div class="new col-md-4">
                                <p class="title-loja-cad">Informe os dados da Loja</p>
                            </div>-->

                            <form action="" method="POST" class="j_new-loja">
                                <div class="col-md-10 control-form custom-form-loja">

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="num">Numero da Loja:</label>
                                        <input type="text" pattern="^[0-9]{4,5}$"  title="Numero Inválido para Loja. Numero da Loja normalmente é composto po 4 números" name="lj_num" class="form-control j_lj_num j_loja_clear" id="num" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="sit">Situação da loja:</label>
                                        <select name="lj_sit" class="form-control j_sit j_clear j_loja_clear" id="sit">
                                            <option value="">Selecione...</option>
                                            <option value="Aberta">Aberta</option>
                                            <option value="Fechada">Fechada</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="ie">Inscrição Estadual:</label>
                                        <input type="text" name="lj_ie" class="form-control j_lj_ie j_loja_clear" id="ie" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="reg">Regional:</label>
                                        <select name="r_cod" class="form-control j_reg j_clear j_loja_clear" id="reg">
                                            <option value="">Selecione...</option>
                                            <?php
                                            foreach ($regional as $num):
                                                echo "<option value='{$num}'>{$num}</option>";
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-5 control-edit control-edit-lj">
                                        <label for="cnpj">CNPJ</label>
                                        <input type="number" name="lj_cnpj" class="form-control j_lj_cnpj j_loja_clear" id="cnpj" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="end">Endereço</label>
                                        <input type="text" name="lj_end" class="form-control j_lj_end j_loja_clear" id="end" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="bai">Bairro</label>
                                        <input type="text" name="lj_bairro" class="form-control j_lj_bairro j_loja_clear" id="bai" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="city">Cidade</label>
                                        <input type="text" name="lj_cidade" class="form-control j_lj_cidade j_loja_clear" id="city" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="uf">Estado</label>
                                        <input type="text"  pattern="^[A-Z]{2}$" title="Informe a Sigla do Estado em Letras maiúsculas" name="lj_uf" class="form-control j_lj_uf j_loja_clear" id="uf" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="fixo">Telefone fixo</label>
                                        <input type="text" name="lj_tel_fix" class="form-control j_lj_fixo j_loja_clear" id="fixo" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="ramal">Ramal:</label>
                                        <input type="text" name="lj_tel_ram" class="form-control j_lj_ramal j_loja_clear" id="ramal" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="corp">Corporativo:</label>
                                        <input type="text" name="lj_tel_ger" class="form-control j_lj_corp j_loja_clear" id="corp" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="func">Hr. de funcionamento:</label>
                                        <input type="text" name="hr_cod" class="form-control j_lj_hora j_loja_clear" id="func" required>
                                    </div>

                                    <div class="form-group col-md-5 control-edit">
                                        <label for="iplj">Ip da Loja:</label>
                                        <input type="text" name="lj_ip_loja" pattern="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}" title="Informe um endereço ip válido"  class="form-control j_lj_ip j_loja_clear" id="iplj" required>
                                    </div>

                                </div>
                                <div class="form-group col-md-5 control-edit action-space">
                                    <button class="btn btn-danger btn-cad-link" type="button">Cadastrar Links</button>
                                    <button class="btn btn-danger btn-salvar-loja"><i class="fa fa-floppy-o" aria-hidden="true"> Salvar</i></button>
                                </div>	
                            </form>
                        </div>
                        <div class="opt col-md-5 j_add-loja add">
                            <button class="btn btn-default btn-new-loja j_btn-new-loja"><i class="fa fa-plus-circle" aria-hidden="true"> Novo</i></button>
                        </div>
                    </div>
                    <!-- REALIZANDO BUSCA DE UMA REGIONAL -->
                    <div class="box box-gtd hide-manager col-md-12">
                        <div class="search-tec col-md-12">
                            <div class="busca-tec col-md-12">
                                <div class="filtro-busca">
                                    <form action="" method="POST" class="j_form-reg">
                                        <div class="form-group col-md-2 aa">
                                            <label for="func">Regional:</label>
                                            <input type="number" name="reg" class="form-control j_reg" id="name" required>
                                        </div>
                                        <div class="res-reg col-md-12">

                                        </div>								
                                        <div class="btn-group grp-btn">
                                            <buttom class="btn btn-default btn-add-new-reg"><i class="fa fa-plus-circle" aria-hidden="true"> Novo</i></buttom>
                                            <button class="btn btn-default"><i class="fa fa-search j_busca-reg" aria-hidden="true"> Buscar</i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- VISUALIZANDO DADOS DA REGIONAL	 -->
                        <div class="detail-regional col-md-12">
                            <div class="row">
                                <div class="block-reg col-md-4">
                                    <h3>Gerente Regional</h3>
                                    <div class="dvGr">
                                        <div class="form-group col-md-9">
                                            <label for="nameGReg">Nome:</label>
                                            <input type="text" name="nameGReg" class="form-control j_edit-Gr" id="nameGReg" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="Corp">Corporativo:</label>
                                            <input type="tel" name="Corp" class="form-control j_edit-Gr" id="corpGReg" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="Corp">Email:</label>
                                            <input type="tel" name="Corp" class="form-control j_edit-Gr" id="emailGReg" disabled>
                                        </div>
                                        <div class="btn-area-reg col-md-9">
                                            <button class="btn btn-warning btn-pos-reg j_edit-reg"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            <button class="btn btn-info btn-pos-reg j_save-Gr" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                        </div>
                                    </div>							
                                </div>
                                <div class="block-reg col-md-4">
                                    <h3>Diretor Regional</h3>
                                    <div class="dvDr">
                                        <div class="form-group col-md-9">
                                            <label for="nameDReg">Nome:</label>
                                            <input type="text" name="nameGReg" class="form-control j_edit-Drg" id="nameDReg" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="CorpD">Corporativo:</label>
                                            <input type="tel" name="CorpD" class="form-control j_edit-Drg" id="corpDReg" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="Corp">Email:</label>
                                            <input type="email" name="email" class="form-control j_edit-Drg" id="emailDReg" disabled>
                                        </div>
                                        <div class="btn-area-reg col-md-9">
                                            <button class="btn btn-warning btn-pos-reg j_edit-Dr"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            <button class="btn btn-info btn-pos-reg j_save-Dr" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                        </div>
                                    </div>							
                                </div>
                                <div class="block-reg col-md-4 j_resp-tec-reg">
                                    <h3>Reponsáveis técnicos</h3>
                                </div>
                            </div>
                            <div class="row">
                                <h3>Lojas Associadas a regional</h3>
                                <div class="block-lojas col-md-12"></div>
                            </div>
                            <div class="btn-group btn-grp-result">
                                <buttom class="btn btn-default btn-back-res"><i class="fa fa-undo" aria-hidden="true"> Voltar</i></buttom>
                            </div>
                        </div>

                        <!-- CADASTRAR NOVA REGIONAL -->

                        <div class="new-reg col-md-12">				
                            <div class="row">	
                                <form method="POST" class="j_new_regional" action="manager">	
                                    <div class="num-reg col-md-12">
                                        <label for="NumReg" class="titleNumreg">Informe o numero da Regional:</label>
                                        <input type="number" name="numReg" class="form-control num-reg-cl j_clr" id="NumReg" required >
                                    </div>
                                    <div class="num-reg col-md-12">
                                        <label for="NumReg" class="titleNameReg">Informe o nome da Região:</label>
                                        <select name="regName" class="j_regional form-control j_clr" required>
                                            <option value="">Selecione...</option>
                                            <option value="Sudeste">Sudeste</option>
                                            <option value="Nordeste 1">Nordeste 1</option>
                                            <option value="Nordeste 2">Nordeste 2</option>
                                            <option value="Centro Norte">Centro Norte</option>
                                            <option value="Centro Sul">Centro Sul</option>
                                        </select>
                                    </div>
                                    <div class="block-reg block-margin col-md-4">
                                        <h3>Gerente Regional</h3>
                                        <div class="dvGr">
                                            <div class="form-group col-md-9">
                                                <label for="nameGReg">Nome:</label>
                                                <input type="text" name="nameGReg" class="form-control j_nome_GR j_clr" id="nameGReg" required >
                                            </div>
                                            <div class="form-group col-md-9">
                                                <label for="Corp">Corporativo:</label>
                                                <input type="tel" name="Corp" class="form-control j_corpGR j_clr" id="corpGReg" required>
                                            </div>
                                            <div class="form-group col-md-9">
                                                <label for="Corp">Email:</label>
                                                <input type="email" name="Corp" class="form-control j_emailGR j_clr" id="emailGReg" required>
                                            </div>
                                        </div>							
                                    </div>
                                    <div class="block-reg block-margin col-md-4">
                                        <h3>Diretor Regional</h3>
                                        <div class="dvDr">
                                            <div class="form-group col-md-9">
                                                <label for="nameDReg">Nome:</label>
                                                <input type="text" name="nameGReg" class="form-control j_nomeDR j_clr" id="nameDReg" required>
                                            </div>
                                            <div class="form-group col-md-9">
                                                <label for="CorpD">Corporativo:</label>
                                                <input type="tel" name="CorpD" class="form-control j_corpDR j_clr" id="corpDReg" required>
                                            </div>
                                            <div class="form-group col-md-9">
                                                <label for="Corp">Email:</label>
                                                <input type="email" name="email" class="form-control j_emailDR j_clr" id="emailDReg" required>
                                            </div>
                                        </div>							
                                    </div>
                            </div>
                            <div class="row">
                                <h3 class="titleRegAssc">Lojas Associadas a regional</h3>
                                <div class="block-lojas-new col-md-12">
                                    <div class="form-group col-md-2">
                                        <label for="numLjreg">Número da loja:</label>
                                        <input type="number" name="numLjre" class="form-control j_nul-lj-reg j_clr" id="numLjreg">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button class="btn btn-default btn-add-lj" type="button" value='add'><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="form-group col-md-8 rel-lojas-reg"></div></div>
                                <div class="btn-group btn-grp-result">
                                    <button class="btn btn-danger btn-back-reg" type="button"><i class="fa fa-undo" aria-hidden="true"> Voltar</i></button>
                                    <input type="submit" class="btn btn-danger" value="Salvar">
                                    </form>	
                                </div>
                            </div>				  
                        </div>
                    </div>
                </div>
            </div>				
        </div>

        <!-- modal -->
        <div id="mdlinfo2" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>O usuário informado já existe</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="mdlinfo3" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>As senhas informadas não coincidem.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo4" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Falha na Gravação dos dados. Informe ao suporte.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo5" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Usuário Cadastrado com sucesso!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_confirm" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo6" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Usuário Atualizado com sucesso!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_confirm-2" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo7" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Favor informar os dados da loja antes de cadastrar o link!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_confirm-3" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalDeleteLoja" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Pergunta:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja apagar a loja?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger j_btn-lj-yes" data-dismiss="modal">SIM</button>
                        <button type="button" class="btn btn-default j_btn-lj-no" data-dismiss="modal">NAO</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo8" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Dados Insuficientes para cadastrar ou não foi feito cadastro dos links da loja.<br> Verifique os dados e tente novamente</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_confirm" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo9" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Dados Inseridos com sucesso. Gostaria de cadastrar outra Loja?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger j_btn-lj-lj-yes" data-dismiss="modal">SIM</button>
                        <button type="button" class="btn btn-default j_btn-lj-lj-no" data-dismiss="modal">NAO</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlinfo10" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Essa Loja já está cadastrada no sistema. Verifique os dados e tente novamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mdlinfo11" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Dados atualizados com sucesso!!!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_btn-lj-lj-no" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mdlinfo12" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Houve uma falha na gravação dos dados ou não houve atualização nos dados.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_btn-lj-lj-no" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mdlinfo13" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header custom-modal">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">SISNOC Informa:</h3>
                    </div>
                    <div class="modal-body">
                        <p>Regional Cadastrada com sucesso!!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default j_btn-reg-confirm" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/scripts.js') ?>"></script>
</body>	
</html>