$(function () {
    /* Funções JS PARA A TELA DE LOGIN*/
    
     var currentUrl = window.location.href;
     var pos =  currentUrl.lastIndexOf("/");
    currentUrl = currentUrl.substr(0, pos);
    
    var urlBase =  currentUrl +'/index.php/ShortHand_Gerenciamento/';
    var urlBaseChamados =  currentUrl +  '/index.php/ShortHand_Chamado/';
    
   

    console.log(urlBase);
    
    $(document).ready(function () {
        $('.login').fadeIn(500);
    });

    /*********************************** Funções da TELA DE MENU _ CONTEÙDO ***********************************************************************/

    /* Menu de Abertura de Ocorrência */

    $('.btn-menu-custom').click(function () {

        var lar = $(window).width();
        if (lar <= 500) {
            var altura = "450px";
        } else if (lar >= 501 && lar <= 1100) {

            var altura = "450px";

        } else if (lar >= 1100) {
            var altura = "240px";
        }

        console.log(altura);

        $('.box-1').animate({height: altura}, 600, function () {
            $('.btn-menu-custom').addClass('largo');
            $('.btn-menu-custom').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recolher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
            $('.btn-menu-custom-2').removeClass('btn-menu-custom');

        });

        $('.ab_ch').fadeIn(500, function () {
            $('.ab_ch').show();
        });
    });

    $('.box-1').on('click', '.largo', function () {

        $('.ab_ch').fadeOut(500, function () {
            $('.ab_ch').hide();
        });

        $('.box-1').animate({height: "65px"}, 600, function () {
            $('.btn-menu-custom-2').html("Abrir Ocorrência");
            $('.btn-menu-custom-2').removeClass('largo');
            $('.btn-menu-custom-2').addClass('btn-menu-custom');
        });
    });

    /* Menu de Gerar senhas */

    $(".j_btn-pass").click(function () {
        $.post( currentUrl + '/assets/ponte/jsPassGenerator.php', function (retorno) {
            console.log(retorno);
            $('.j_resultado').val(retorno);
        });
    });

    /* Menu Abertura de ocorrências */
    /* Verificando se a loja possui o link informado */
    $('.j_link').change(function () {
        var numlj = $('.jnum-lj').val();
        var link = $(this).val();
        console.log(numlj);
        $.post(urlBaseChamados + 'LinkExistis', {cir_loja: numlj, cir_link: link}, function (r) {
            console
            if (r == 'false') {
                alert("A loja informada não possui o link informado. Verifique os dados e tente novamente");
                window.location.reload();
            }
        });
    });
    
    /* Verificando o status da loja */
    $('.jStatusLoja').change(function () {
        var numlj = $('.jnum-lj').val();
        var link = $(this).val();
        console.log(numlj);

        if (link != 'Loja Offline') {
            $.post(urlBaseChamados + 'LinkExistis', {cir_loja: numlj, cir_link: link}, function (r) {
                console
                if (r == 'false') {
                    alert("A loja informada não possui o link informado. Verifique os dados e tente novamente");
                    window.location.reload();
                }
            });
        }
             
    });
    
    /***********************************************************************************************************************************************/
    

    /***************************************************Scripts relacionados a tela de gerenciamento ******************************************/


    /* Sistema de abas */
    $('.j_usuario').click(function () {
        $('.box-lojas').addClass('hide-manager');
        $('.box-gtd').addClass('hide-manager');
        $('.box-users').removeClass('hide-manager');

    });

    $('.j_loja').click(function () {
        $('.box-users').addClass('hide-manager');
        $('.box-gtd').addClass('hide-manager');
        $('.box-lojas').removeClass('hide-manager');

    });

    $('.j_gtd').click(function () {
        $('.box-users').addClass('hide-manager');
        $('.box-lojas').addClass('hide-manager');
        $('.box-gtd').removeClass('hide-manager');
    });


    /***************************************************ABA DE USUÀRIOS************************************************************/
    /* Buscar usuário digitado */
    $('.j_search').submit(function () {
        var form = $(this);
        var dados = form.find('.j_termo-user').val();
        var card = document.getElementsByClassName('card').length;


        $.ajax({

            url: urlBase + 'shorthand/',
            type: 'POST',
            data: {u_user: dados},
            datatype: 'json',

            beforeSend: function () {

            },

            success: function (resposta) {
                var arrjson = jQuery.parseJSON(resposta);
                if (card >= 1) {
                    $('.card').remove();
                }
                $.each(arrjson.Dados, function (key, value) {
                    $('.card-users').append("<div id='" + value.u_cod + "' class='panel panel-success col-md-4 card'><div class='panel-heading'><h3>" + value.u_nome + "</h3></div><div class='panel-body'><p>Função: " + value.u_funcao + "</p><p>Email: " + value.u_email + "</p><p>Usuario: " + value.u_user + "</p><p>Ultima vez logado: " + value.u_last_login + "</p></div><div class='panel-footer'><button class='btn btn-warning j_edit' value='" + value.u_user + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button><button value='" + value.u_user + "' id='" + value.u_cod + "'  data-toggle='modal' data-target='#modalDelete' class='btn btn-danger j_delete'><i class='fa fa-trash' aria-hidden='true'></i></button></div></div>");
                });
            }
        });

        return false;

    });

    /* Botões de ação nos cards de usuário */

    /* Deletar */
    $('.card-users').on('click', '.j_delete', function () {
        idUser = $(this).val();
        idclick = $(this).attr('id');
    });


    /* Ação no modal de deletar usuario */
    $('.j_btn-yes').click(function () {
        $.ajax({
            url: urlBase + 'del/',
            type: 'POST',
            datatype: 'json',
            data: {u_user: idUser},
            beforeSend: function () {

            },
            success: function () {
                $('#' + idclick).fadeOut(function () {
                    $('#' + idclick).remove();
                })
            }
        });
    });

    /* Editar cadastro */
    $('.card-users').on('click', '.j_edit', function () {

        idUserEdit = $(this).val();

        $.ajax({
            url: urlBase + 'shorthand/',
            type: 'POST',
            datatype: 'json',
            data: {u_user: idUserEdit},
            beforeSend: function () {

            },

            success: function (retorno) {
                var userdados = jQuery.parseJSON(retorno);
                var controlInput = document.getElementsByClassName('edit').length;
                $('.j_name').val(userdados.Dados[0].u_nome);
                $('.j_funcao').val(userdados.Dados[0].u_funcao);
                $('.j_email').val(userdados.Dados[0].u_email);
                $('.j_tel').val(userdados.Dados[0].u_tel);
                $('.j_user_name').val(userdados.Dados[0].u_user);
                $('.j_ativate').val(userdados.Dados[0].u_ativo);
                $('.j_nivel').val(userdados.Dados[0].u_nivel_acesso);
                $('.j_pass').removeAttr('required');
                $('.j_pass2').removeAttr('required');


                if (controlInput == 0) {
                    $('.control-edit').append("<input type='hidden' value='edit' class='edit' name='hidden-field'>");
                    $('.control-edit').append("<input type='hidden' value=" + userdados.Dados[0].u_cod + " class='cod_u' name='u_cod'>");
                }

            }

        });


        $('.busca-user').fadeOut(500, function () {
            $('.new-user').fadeIn(500);
            $('.j_btn-new-user').remove();
            $('.j_add').append("<button class='btn btn-default btn-new-user j_flag_back'><i class='fa fa-undo' aria-hidden='true'>Voltar</i></button>");
        });


    });


    /* Ação ao clicar em novo */

    $('.opt').on('click', '.j_btn-new-user', function () {

        $('.j_user_clear').val('');
        $('.edit').remove();
        $('.cod_u').remove();
        $('.j_pass').prop('required', true);
        $('.j_pass2').prop('required', true);

        $('.busca-user').fadeOut(500, function () {
            $('.new-user').fadeIn(500);
            $('.j_btn-new-user').remove();
            $('.j_add').append("<button class='btn btn-default btn-new-user j_flag_back'><i class='fa fa-undo' aria-hidden='true'>Voltar</i></button>");
        });

    });


    /* Ação ao clicar em voltar */

    $('.opt').on('click', '.j_flag_back', function () {
        $('.new-user').fadeOut(500, function () {
            $('.busca-user').fadeIn(500);
        });
        $('.j_flag_back').remove();
        $('.j_add').append("<button class='btn btn-default btn-new-user j_btn-new-user j_btn-new'><i class='fa fa-plus-circle' aria-hidden='true'> Novo</i></button>");
    });

    /* Submeter formulário para cadastro de usuário */

    $('.j_new_user').submit(function () {

        var ctl_edit = document.getElementsByClassName('edit').length;

        var formDados = {
            'u_nome': $('input[name=u_nome]').val(),
            'u_user': $('input[name=u_user]').val(),
            'u_funcao': $('input[name=u_funcao]').val(),
            'u_email': $('input[name=u_email]').val(),
            'u_tel': $('input[name=u_tel]').val(),
            'u_senha': $('input[name=u_senha]').val(),
            'u_senha2': $('input[name=u_senha2]').val(),
            'u_ativo': $('select[name=u_ativo]').val(),
            'u_nivel_acesso': $('select[name=u_nivel_acesso]').val()
        };

        if (ctl_edit >= 1) {
            formDados['edit'] = $('input[name=hidden-field]').val();
            formDados['u_cod'] = $('input[name=u_cod]').val();
            var url = urlBase + 'updateUsuario/';
        } else {
            var url = urlBase + 'insereUsuario/';
        }

        $.ajax({
            url: url,
            type: 'POST',
            datatype: 'json',
            data: {dados: formDados},

            beforeSend: function () {


            },
            success: function (dados) {

             

                if (dados == 'existe') {
                    $('#mdlinfo2').modal('show');
                } else if (dados == 'pass') {
                    $('#mdlinfo3').modal('show');
                } else if (dados == 'falha-01') {
                    $('#mdlinfo4').modal('show');                    
                } else if (dados == 'falha-02') {
                    $('#mdlinfo4').modal('show');  
                } else if (dados == 'done') {
                    $('#mdlinfo6').modal('show');
                } else {
                    $('#mdlinfo5').modal('show');
                }

            }
        });
        return false;

    });

    /*Limpar os campos após o cadastro do usuário!*/
    $('.j_confirm').click(function () {
        $('.j_user_clear').val('');
    });

    /* Ação após confirmar que foi atualizado os dados do usuário! */

    $('.j_confirm-2').click(function () {
        $('.new-user').fadeOut(500, function () {
            $('.busca-user').fadeIn(500);
        });
        $('.j_flag_back').remove();
        $('.j_add').append("<button class='btn btn-default btn-new-user j_btn-new-user j_btn-new'><i class='fa fa-plus-circle' aria-hidden='true'> Novo</i></button>");
    });

    /***************************************************ABA de GESTAO DAS LOJAS***************************************************/

    $('.j_search-loja').submit(function () {
        var form = $(this);
        var dados = form.find('.j_termo-loja').val();
        var card = document.getElementsByClassName('card-lojas').length;


        $.ajax({

            url: urlBase + 'buscalojas/',
            type: 'POST',
            data: {lj_num: dados},
            datatype: 'json',

            beforeSend: function () {

            },

            success: function (respostaLoja) {
                var arrjsonLojas = jQuery.parseJSON(respostaLoja);
                if (card >= 1) {
                    $('.card-lojas').remove();
                }

                $.each(arrjsonLojas.Dados, function (key, value) {
                    $('.card-area-lojas').append("<div id=" + value.lj_cod + " value=" + value.lj_cod + " class='panel panel-success col-md-4 card-lojas'><div class='panel-heading'><p class='panel-title title-loja'>" + value.lj_num + "</p></div><div class='panel-body'><p>Estado: " + value.lj_uf + "</p><p>Cidade: " + value.lj_cidade + "</p><p>Bairro: " + value.lj_bairro + "</p><p>Situação: " + value.lj_sit + "</p></div><div class='panel-footer'><button id=" + value.lj_num + " class='btn btn-warning j_edit-loja'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button><button data-target='#modalDeleteLoja' data-toggle='modal' id=" + value.lj_cod + " value=" + value.lj_cod + " class='btn btn-danger btn-del-lj'><i class='fa fa-trash' aria-hidden='true'></i></button></div></div>");
                });
            }
        });

        return false;

    });

    /* Ação ao clicar em deletar- loja */
    $('.card-area-lojas').on('click', '.btn-del-lj', function () {
        idloja = $(this).attr('id');
    });


    $('.j_btn-lj-yes').click(function () {

        $.ajax({
            url: urlBase + 'delLojas/',
            type: 'POST',
            datatype: 'json',
            data: {lj_cod: idloja},
            beforeSend: function () {

            },
            success: function () {
                $('#' + idloja).fadeOut(function () {
                    $('#' + idloja).remove();
                })
            }
        });
    });

    /* Editar dados da loja */

    $('.card-area-lojas').on('click', '.j_edit-loja', function () {
        idbloja = $('.j_edit-loja').attr('id');


        $.post(urlBase + 'buscalojas', {lj_num: idbloja}, function (retorno) {
            var loja = jQuery.parseJSON(retorno);
            var btn_vl = document.getElementsByClassName('btn-list-link').length;
            var edit_ctl = document.getElementsByClassName('edit-loja').length;

            $('.j_lj_num').val(loja.Dados[0].lj_num);
            $('.j_sit').val(loja.Dados[0].lj_sit);
            $('.j_lj_ie').val(loja.Dados[0].lj_ie);
            $('.j_reg').val(loja.Dados[0].r_cod);
            $('.j_lj_cnpj').val(loja.Dados[0].lj_cnpj);
            $('.j_lj_end').val(loja.Dados[0].lj_end);
            $('.j_lj_bairro').val(loja.Dados[0].lj_bairro);
            $('.j_lj_cidade').val(loja.Dados[0].lj_cidade);
            $('.j_lj_uf').val(loja.Dados[0].lj_uf);
            $('.j_lj_fixo').val(loja.Dados[0].lj_tel_fix);
            $('.j_lj_ramal').val(loja.Dados[0].lj_tel_ram);
            $('.j_lj_corp').val(loja.Dados[0].lj_tel_ger);
            $('.j_lj_hora').val(loja.Dados[0].hr_cod);
            $('.j_lj_ip').val(loja.Dados[0].lj_ip_loja);



            $('.btn-cad-link').remove();

            if (btn_vl == 0) {
                $('.action-space').append("<button class='btn btn-danger btn-list-link j_btn-list-link' type='button'>Visualizar Links</button>");
            }

            if (edit_ctl == 0) {
                $('.control-edit-lj').append("<input type='hidden' value='edit-loja' name='edit-lj' class='j_ctl_rem'>");
                $('.control-edit-lj').append("<input type='hidden' value=" + loja.Dados[0].lj_cod + " name='edit-lj-cod' class='j_ctl_rem'>");

            }

            $('.j_btn-new-loja').remove();
            $('.j_add-loja').append("<button class='btn btn-default btn-new-lj j_flag_back-lj'><i class='fa fa-undo' aria-hidden='true'>Voltar</i></button>");
            $('.search-loja').fadeOut(500, function () {
                $('.new-loja').fadeIn(500);
            });



        });

    });


    /* Ação ao Clicar em Visualizar links */
    $('.action-space').on('click', '.j_btn-list-link', function () {
        window.open('checklink?loja=' + $('.j_lj_num').val(), 'linkVer', 'width=650, height=450');
    });



    /* Ação ao clicar no botão novo na area de lojas */
    $('.j_add-loja').on('click', '.j_btn-new-loja', function () {

        $('.j_search-loja').fadeOut(500, function () {
            $('.new-loja').fadeIn(500);
            $('.j_btn-new-loja').remove();
            $('.j_btn-list-link').remove();
            $('.j_ctl_rem').remove();
            if (document.getElementsByClassName('btn-cad-link').length == 0) {
                $('.action-space').append("<button class='btn btn-danger btn-cad-link' style='position:relative; top: -52px;' type='button'>Cadastrar Links</button>");
            }
            $('.j_loja_clear').val('');
            $('.j_add-loja').append("<button class='btn btn-default btn-new-lj j_flag_back-lj'><i class='fa fa-undo' aria-hidden='true'>Voltar</i></button>");
        });
    });


    /* Janela de Cadastrar novo Link */

    /* Abrir Janela de Cadastro */
    $('.action-space').on('click', '.btn-cad-link', function () {

        var nlj = $('.j_lj_num').val();
        var end = $('.j_lj_end').val();
        var bar = $('.j_lj_bairro').val();
        var city = $('.j_lj_cidade').val();
        var uf = $('.j_lj_uf').val();
        var corp = $('.j_lj_corp').val();

        window.sessionStorage.setItem('loja', nlj);

        console.log(nlj);

        if (nlj == '' || end == '' || bar == '' || city == '' || uf == '' || corp == '') {
            $('#mdlinfo7').modal('show');
        } else {
            window.open('cad-link', 'janela', 'width=500, height=450');
        }

    });

    /* Ação ao Salvar os dados do link */
    $('.j_cad_link').submit(function () {

        var nlj_rec = window.sessionStorage.getItem('loja');

        console.log(nlj_rec);

        var link = {
            'cir_loja': nlj_rec,
            'cir_desig': $('input[name=cir_desig]').val(),
            'cir_oper': $('input[name=cir_oper]').val(),
            'cir_ip_link': $('input[name=cir_ip_link]').val(),
            'cir_link': $('.j_link-loja').val(),
            'cir_band': $('input[name=cir_band]').val(),
        };

        console.log(link);

        $.ajax({
            url: urlBase + 'cadastraLink/',
            type: 'POST',
            data: link,
            datatype: 'json',
            beforeSend: function () {

            },
            success: function (retorno) {

                if (retorno == 'falha-dados') {
                    $('#mdcadinfo').modal('show');
                } else {
                    $('#mdcadinfo2').modal('show');
                }

            }

        });

        return false;
    });


    /* Ações na tela de edição dos links das lojas */
    /* Habilitar a ediçao dos dados */
    $('.j-edit-link').click(function () {
        var id = $(this).attr("id");
        $('#' + id).find('.j_edit-link-loja').removeAttr('disabled');
    });

    /* Salvar dados */
    $('.j-save-link').click(function () {
        var lnk = $(this).attr("id");

        dadosLink = {
            'cir_link': $('#' + lnk).find('#link').val(),
            'cir_oper': $('#' + lnk).find('#opr').val(),
            'cir_desig': $('#' + lnk).find('#cir').val(),
            'cir_ip_link': $('#' + lnk).find('#ip').val(),
            'cir_band': $('#' + lnk).find('#vel').val(),
            'cir_cod': $('#' + lnk).find('#cod').val(),
            'id-div': lnk
        };

        console.log(dadosLink);

        $.post(urlBase + 'atualizaLink', {Link: dadosLink}, function (retorno) {
            if (retorno != "erro") {
                console.log(retorno);
                $('#' + retorno).find('.j_edit-link-loja').attr('disabled', 'disabled');
            }
        });


    });

    /* Deletar Link */
    /*Modal*/
    $('.j-del-link').click(function () {
        lnk = $(this).attr("id");
        $('#modalDeletelink').modal();

    });
    /*Excluir*/
    $('.j_btn-lnk-rm-yes').click(function () {
        var cod = $('#' + lnk).find('#cod').val();
        console.log(cod);
        $.post(urlBase + 'removeLink', {cir_cod: cod}, function (retorno) {
            if (retorno != 'false') {
                $('#' + lnk).fadeOut(500);
            } else {
                $('#modalDeletelink-2').modal();
            }
        });
    });

    /*Excluir elemento delete dinamico*/
    $('.navbar-custom').on('click', '.j-del-link-add', function () {
        $('#' + $(this).val()).remove();
    });

    /* Fechar janela de edição de links */
    $('.j_close_link').click(function () {
        window.close();
    });


    /* Botão Adicionar link na loja */
    $('.j_add_link').click(function () {

        var lastid = $('.navbar-custom').children().eq(-1).attr("id");
        lastid++;

        var lj = document.getElementById('loja').val;

        console.log(lastid);

        $('.navbar-custom').append("<div class='container-fluid form-horizontal' id=" + lastid + ">" +
                "<div class='form-group col-md-2 col-xs-2 custom-div-link'>" +
                "<label for='link' class='col-md-2 control-label'>Link</label>" +
                "<input type='text' name='' id='link' class='form-control input-sm j_edit-link-loja bkg'>" +
                "<input type='hidden' name='cir_cod' id='cod' value=''>" +
                "</div>" +
                "<div class='form-group col-md-2 col-xs-2 custom-div-link'>" +
                "<label for='opr' class='col-md-2 control-label'>Operadora</label>" +
                "<input type='text'  value='' name='' id='opr' class='form-control input-sm j_edit-link-loja bkg'>" +
                "<input type='hidden' name='cir_loja' id='loja' value=" + lj + ">" +
                "</div>" +
                "<div class='form-group col-md-2 col-xs-3 custom-div-link'>" +
                "<label for='cir' class='col-md-2 control-label'>Circuito</label>" +
                "<input type='text'  value='' name='' id='cir' class='form-control input-sm j_edit-link-loja bkg'>" +
                "</div>" +
                "<div class='form-group col-md-2 col-xs-3 custom-div-link'>" +
                "<label for='ip' class='col-md-2 control-label'>IP Mon.</label>" +
                "<input type='text'  value='' name='' id='ip' class='form-control input-sm j_edit-link-loja bkg'>" +
                "</div>" +
                "<div class='form-group col-md-2 col-xs-2 custom-div-link'>" +
                "<label for='vel' class='col-md-2 control-label'>Banda</label>" +
                "<input type='text' value='' name='' id='vel' class='form-control input-sm j_edit-link-loja bkg'>" +
                "</div>" +
                "<div class='btn-area'>" +
                "<button id=" + lastid + " class='btn btn-primary btn-custom j-save-link-add' data-toogle='tooltip' value=" + lastid + " data-placement='top' title='Salvar'><i class='fa fa-floppy-o' aria-hidden='true'></i></button>" +
                "<button id=" + lastid + " class='btn btn-danger btn-custom j-del-link-add' value=" + lastid + "><i class='fa fa-trash-o' aria-hidden='true'></i></button>" +
                "</div>" +
                "</div>");
    });

    $('.navbar-custom').on('click', '.j-save-link-add', function () {

        var lj = document.getElementById('loja').val;

        var DadosLnk = {
            'cir_link': $('#' + $(this).val()).find('#link').val(),
            'cir_oper': $('#' + $(this).val()).find('#opr').val(),
            'cir_desig': $('#' + $(this).val()).find('#cir').val(),
            'cir_ip_link': $('#' + $(this).val()).find('#ip').val(),
            'cir_band': $('#' + $(this).val()).find('#vel').val(),
            'cir_loja': $('#loja').val()
        };

        $.ajax({
            url: urlBase + 'cadastraLink/',
            type: 'POST',
            data: DadosLnk,
            datatype: 'json',
            success: function (retorno) {

                if (retorno == 'true') {
                    console.log(retorno);
                    location.reload();
                }
            }
        });
    });



    /* Ação ao Salvar os dados da loja */

    $('.j_new-loja').submit(function () {
        var lj = $('.j_lj_num').val();
        var edit = document.getElementsByName('edit-lj').length;
        console.log(edit);

        if (lj == '') {
            $('#mdlinfo7').modal('show');

        } else if (edit >= 1) {

            $.post('http://localhost/CI_SISNOC/assets/ponte/CheckTecReg.php', {loja: $('.j_lj_num').val(), uf: $('input[name=lj_uf]').val()}, function (volta) {
                var tec = jQuery.parseJSON(volta);
                var arrloja = {
                    'lj_num': $('.j_lj_num').val(),
                    'lj_ie': $('input[name=lj_ie]').val(),
                    'lj_cnpj': $('input[name=lj_cnpj]').val(),
                    'lj_bairro': $('input[name=lj_bairro]').val(),
                    'lj_uf': $('input[name=lj_uf]').val(),
                    'lj_tel_ram': $('input[name=lj_tel_ram]').val(),
                    'hr_cod': $('input[name=hr_cod]').val(),
                    'lj_sit': $('select[name=lj_sit]').val(),
                    'r_cod': $('select[name=r_cod]').val(),
                    'lj_end': $('input[name=lj_end]').val(),
                    'lj_cidade': $('input[name=lj_cidade]').val(),
                    'lj_tel_fix': $('input[name=lj_tel_fix]').val(),
                    'lj_tel_ger': $('input[name=lj_tel_ger]').val(),
                    'lj_ip_loja': $('input[name=lj_ip_loja]').val(),
                    'gr_cod': $('.j_reg').val(),
                    'b_cod': tec.Band,
                    'tr_cod': tec.RespTec,
                    'lj_cod': $('input[name=edit-lj-cod]').val()
                };

                $.post(urlBase + 'updateLoja', {loja: arrloja}, function (retorno) {
                    if (retorno == '1') {
                        $('#mdlinfo11').modal();
                    } else {
                        $('#mdlinfo4').modal();
                    }
                });
            });
        } else {
            $.ajax({
                url: urlBase + 'verLink/' + lj,
                type: 'POST',
                datatype: 'json',

                success: function (resposta) {

                    if (resposta == 'no') {
                        $('#mdlinfo8').modal('show');
                    } else {

                        $.post('http://localhost/CI_SISNOC/assets/ponte/CheckTecReg.php', {loja: $('.j_lj_num').val(), uf: $('input[name=lj_uf]').val()}, function (volta) {

                            var tec = jQuery.parseJSON(volta);
                            var arrloja = {
                                'lj_num': $('.j_lj_num').val(),
                                'lj_ie': $('input[name=lj_ie]').val(),
                                'lj_cnpj': $('input[name=lj_cnpj]').val(),
                                'lj_bairro': $('input[name=lj_bairro]').val(),
                                'lj_uf': $('input[name=lj_uf]').val(),
                                'lj_tel_ram': $('input[name=lj_tel_ram]').val(),
                                'hr_cod': $('input[name=hr_cod]').val(),
                                'lj_sit': $('select[name=lj_sit]').val(),
                                'r_cod': $('select[name=r_cod]').val(),
                                'lj_end': $('input[name=lj_end]').val(),
                                'lj_cidade': $('input[name=lj_cidade]').val(),
                                'lj_tel_fix': $('input[name=lj_tel_fix]').val(),
                                'lj_tel_ger': $('input[name=lj_tel_ger]').val(),
                                'lj_ip_loja': $('input[name=lj_ip_loja]').val(),
                                'gr_cod': $('.j_reg').val(),
                                'b_cod': tec.Band,
                                'tr_cod': tec.RespTec
                            };

                            $.post(urlBase + 'insertLoja', {loja: arrloja}, function (retorno) {
                                console.log(retorno);

                                if (retorno == 'erro') {
                                    $('#mdlinfo4').modal('show');
                                } else if (retorno == 'salvo') {
                                    $('#mdlinfo9').modal('show');
                                } else if (retorno == 'existe-cad') {
                                    $('#mdlinfo10').modal('show');
                                }

                            });
                        });

                    }
                }
            });
        }

        return false;

    });




    /*Ação tomada no modal de cadastro de links*/

    $('.j_btn-lj-lk-yes').click(function () {
        $('.j_loja_clear').val('');
    });

    $('.j_btn-lj-lk-no').click(function () {
        window.close();
    });

    /* Ação tomada no modal de cadastro de lojas */

    $('.j_btn-lj-lj-yes').click(function () {
        $('.j_loja_clear').val('');
    });

    $('.j_btn-lj-lj-no').click(function () {
        $('.new-loja').fadeOut(500, function () {
            $('.j_search-loja').fadeIn(500);
            $('.j_flag_back-lj').remove();
            $('.j_loja_clear').val('');
            $('.j_add-loja').append('<button class="btn btn-default btn-new-loja j_btn-new-loja"><i class="fa fa-plus-circle" aria-hidden="true"> Novo</i></button>');
        })
    });

    $('.j_add-loja').on('click', '.j_flag_back-lj', function () {
        $('.new-loja').fadeOut(500, function () {
            $('.search-loja').fadeIn(500);
            $('.j_flag_back-lj').remove();
            $('.j_add-loja').append('<button class="btn btn-default btn-new-loja j_btn-new-loja"><i class="fa fa-plus-circle" aria-hidden="true"> Novo</i></button>');
        })
    });

    /*********************************************ABA de Gestão de regionais****************************************************************/

    $('.j_reg').bind('input', function () {
        nReg = $(this).val();
    });

    $('.j_form-reg').submit(function () {

        $.post(urlBase + 'infoRegionais/', {nReg: nReg}, function (retorno) {
            arrReg = jQuery.parseJSON(retorno);


            var qtdres = document.getElementsByClassName('nav-jq').length;

            if (qtdres >= 1) {
                $('.nav-jq').remove();
            }

            $('.res-reg').append("<nav class='navbar navbar-default nav-jq'>" +
                    "<div class='container'>" +
                    "<div class='navbar-header custom-navbar'>" +
                    "<p>Reg: " + arrReg.regional + "</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<p>" + arrReg.qtdLj + " Lojas</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<p>Diretor Reg.: " + arrReg.DiretorRegional.dr_nome + "</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<p>Gerente Reg.: " + arrReg.GerenteRegional.gr_nome + "</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<buttom class='btn btn-danger j_details'>Detalhes</buttom>" +
                    "</div>" +
                    "</div>" +
                    "</nav>");

            console.log(arrReg);
        });
        return false;
    });

    $('.res-reg').on('click', '.j_details', function () {
        /* Alimentando dados do gerente regional */
        $('#nameGReg').val(arrReg.GerenteRegional.gr_nome);
        $('#corpGReg').val(arrReg.GerenteRegional.gr_corp);
        $('#emailGReg').val(arrReg.GerenteRegional.gr_email);

        /* Alimentando dados do diretor regional */
        $('#nameDReg').val(arrReg.DiretorRegional.dr_nome);
        $('#corpDReg').val(arrReg.DiretorRegional.dr_corp);
        $('#emailDReg').val(arrReg.DiretorRegional.dr_email);

        /* Alimentando dados dos responsáveis técnicos */
        $('.j_resp_tec-reg').remove();

        $.each(arrReg.respTecnicos, function (key, value) {
            $('.j_resp-tec-reg').append("<p class='col-md-7 j_resp_tec-reg'>" + value.resp_nome + "</p><p class='col-md-1 j_resp_tec-reg'>" + value.resp_estado + "</p><button value=" + value.resp_cod + " class='btn btn-default col-md-2 btn-edit-resp-tec j_resp_tec-reg'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>");
        });

        $('.j_resp-tec-reg').append("<div class='btn-area-add col-md-12 j_resp_tec-reg'>" +
                "<button class='btn btn-primary j_add-resp-tec j_resp_tec-reg'><i class='fa fa-plus' aria-hidden='true'> Novo</i></button></div>");

        $('.j_resp-tec-reg').append("<h3 class='col-md-12 j_resp_tec-reg'>Nº de Lojas</h3>");
        $('.j_resp-tec-reg').append("<p class='j-qtds col-md-12 j_resp_tec-reg'>" + arrReg.qtdLj + "</p>");

        /* Alimentando das lojas associadas a regional */
        $.each(arrReg.lojas, function (key, value) {
            var arrInfoLj = value.split("#");
            $('.block-lojas').append("<nav class='navbar navbar-default j_resp_tec-reg'>" +
                    "<div class='container custom-container'>" +
                    "<div class='navbar-header custom-navbar'>" +
                    "<p>Loja: " + arrInfoLj[0] + "</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<p> Estado: " + arrInfoLj[1] + "</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<p>Cidade: " + arrInfoLj[2] + "</p>" +
                    "</div>" +
                    "<div class='navbar-left custom-navbar'>" +
                    "<p>Bairro: " + arrInfoLj[3] + "</p>" +
                    "</div></div>" +
                    "</nav>");
        });

        $('.search-tec').fadeOut(500, function () {
            $('.detail-regional').fadeIn(500);
        });
    });

    /* Gerenciando dados do Gerente Regional */
    /* Editar dados */
    $('.j_edit-reg').click(function () {
        $('.dvGr').find('.j_edit-Gr').removeAttr('disabled');
        $('.dvGr').find('.j_save-Gr').removeAttr('disabled');
    });
    /* Salvar dados */
    $('.j_save-Gr').click(function () {
        var gerReg = {
            'gr_nome': $('#nameGReg').val(),
            'gr_corp': $('#corpGReg').val(),
            'gr_email': $('#emailGReg').val(),
            'gr_cod': arrReg.GerenteRegional.gr_cod,
        };
        $.post(urlBase + 'atualizaGRegional', {GerReg: gerReg}, function (retorno) {

            if (retorno == 'false') {
                $('#mdlinfo12').modal();
            }
            $('.dvGr').find('.j_edit-Gr').attr('disabled', 'disabled');
            $('.dvGr').find('.j_save-Gr').attr('disabled', 'disabled');
        });
    });

    /* Gerenciando dados do Diretor Regional */
    /* Editar dados */
    $('.j_edit-Dr').click(function () {
        $('.dvDr').find('.j_edit-Drg').removeAttr('disabled');
        $('.dvDr').find('.j_save-Dr').removeAttr('disabled');
    });
    /* Salvar dados */
    $('.j_save-Dr').click(function () {
        var dirReg = {
            'dr_nome': $('#nameDReg').val(),
            'dr_corp': $('#corpDReg').val(),
            'dr_email': $('#emailDReg').val(),
            'dr_cod': arrReg.DiretorRegional.dr_cod
        };

        $.post(urlBase + 'atualizaDRegional', {DirReg: dirReg}, function (retorno) {
            if (retorno == 'false') {
                $('#mdlinfo12').modal();
            }
            $('.dvDr').find('.j_edit-Drg').attr('disabled', 'disabled');
            $('.dvDr').find('.j_save-Dr').attr('disabled', 'disabled');
        });
    });

    /* Editando dados dos resp. técnicos */
    $('.j_resp-tec-reg').on('click', '.btn-edit-resp-tec', function () {
        var idtec = parseInt($(this).val());
        window.open('tec-cad?cod=' + idtec, 'janela2', 'width=500, height=450');
    });

    /* Salvado os dados editados do responsável técnico */
    $('.edit-resp').submit(function () {

        var action = document.getElementsByClassName('cod').length;

        console.log(action);

        var tecDados = {
            'resp_nome': $('#nome').val(),
            'resp_corp': $('#corp').val(),
            'resp_email': $('#mail').val(),
        };

        if (action >= 1) {
            tecDados['resp_cod'] = $('#cod').val();
        } else {
            tecDados['insert'] = 'insert';
        }

        $.post(urlBase + 'atualizatec', {tecDados: tecDados}, function (retorno) {
            if (retorno == 'true') {
                $('#mdlinfo11').modal();
            } else {
                $('#mdlinfo12').modal();
            }
        });

        return false;
    });

    $('.j_btn-tec-conf').click(function () {
        window.close();
    });

    /* Adicionando o novo responsável técnico */
    $('.j_resp-tec-reg').on('click', '.j_add-resp-tec', function () {
        window.open('tec-cad', 'janela2', 'width=500, height=450');
    });

    $('.btn-back-res').click(function () {
        $('.detail-regional').fadeOut(500, function () {
            $('.search-tec').fadeIn(500);
        });
    });

    $('.btn-add-new-reg').click(function () {
        $('.search-tec').fadeOut(500, function () {
            $('.new-reg').fadeIn(500);
        });
    });

    /* Cadastro de uma nova regional */

    /* Adicionando lojas na nova regional */
    $('.j_nul-lj-reg').bind('input', function () {
        lojaNewRegional = $(this).val();
    });

    $('.btn-add-lj').click(function () {

        var qtdbtn = document.getElementsByClassName('j_btn-lj-reg').length;

        $('.rel-lojas-reg').append("<button class='btn btn-danger j_btn-lj-reg btn-lj-reg' id=" + qtdbtn + " value=" + lojaNewRegional + ">" + lojaNewRegional + "</button>");
    });

    /* Removendo lojas da regional */
    $('.rel-lojas-reg').on('click', '.j_btn-lj-reg', function () {
        $(this).remove();
    });

    /* Salvando dados da Regional */
    $('.j_new_regional').submit(function () {

        var newregional = $('.num-reg-cl').val();
        var nameregional = $('.j_regional').val();
        var GRegionalNew = {
            'gr_nome': $('.j_nome_GR').val(),
            'gr_corp': $('.j_corpGR').val(),
            'gr_email': $('.j_emailGR').val()
        };

        var DRegionalNew = {
            'dr_nome': $('.j_nomeDR').val(),
            'dr_corp': $('.j_corpDR').val(),
            'dr_email': $('.j_emailDR').val()
        };

        var lojasNewReg = [];
        var qtdBtnLj = document.getElementsByClassName('j_btn-lj-reg').length;

        for (i = 0; i <= qtdBtnLj; i++) {
            lojasNewReg[i] = $("#" + i).val();
        }
        lojasNewReg = lojasNewReg.toString();
        console.log(lojasNewReg);

        $.post(urlBase + 'cadRegional', {r_num: newregional, r_name: nameregional, Greg: GRegionalNew, Dreg: DRegionalNew, LojasReg: lojasNewReg}, function (retorno) {
            if (retorno == 'done') {
                $('#mdlinfo13').modal();
            } else {
                console.log(retorno);
                alert("Falha no cadastro da Regional. Favor consultar o suporte!");
            }
        });
        return false;
    });

    $('.j_btn-reg-confirm').click(function () {
        $('.new-reg').fadeOut(500, function () {
            $('.search-tec').fadeIn(500);
            $('.j_clr').val('');
            $('.j_btn-lj-reg').remove();
        });
    });

    $('.btn-back-reg').click(function () {
        $('.new-reg').fadeOut(500, function () {
            $('.search-tec').fadeIn(500);
            $('.j_clr').val('');
            $('.j_btn-lj-reg').remove();
        });
    });

});