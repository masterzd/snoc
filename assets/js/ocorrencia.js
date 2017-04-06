$(function () {
    /*Arquivo Js responsável pela tela de Ocorrência*/

    var urlBaseCh = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_Gerenciamento';

    /* Config. da descrição dos botões atualizar e mais informações */
    $('[data-toogle="tooltip"]').tooltip();


    /* Script para Configurar a adição de tipo de ocorrencia e Ação tomada */

    /* Adicionar Input Select em Tipo de Problema */

    $('.j_btn').click(function () {
        var a = document.getElementsByClassName('j_control').length;
        if (a <= 2) {
            $('.j_tp').find('.j_select').eq(0).clone().appendTo('.j_tp');
        }
        a++;
        if (a == 2) {
            $('.j_tp').append("<button class='j btn btn-danger btn-add btn-remove'><i class='fa fa-minus' aria-hidden='true'></i></button>");
        }

        return false;
    });

    /* Remover Input Select Tipo de Problema */


    $('.j_tp').on('click', '.j', function () {

        var a = document.getElementsByClassName('j_control').length;

        if (a > 1) {
            $('.j_tp').find('.j_control').eq(-1).remove();
        }
        if (a == 2) {
            $('.j').remove();
        }

        return false;
    });

    /* Adicionar Input Select em Ação Tomada */

    $('.j_btn2').click(function () {

        var a = document.getElementsByClassName('j_control2').length;
        if (a <= 2) {
            $('.j_ac ').find('.j_select2').eq(0).clone().appendTo('.j_ac');
        }
        a++;
        if (a == 2) {
            $('.j_ac').append("<button class='j_a btn btn-danger btn-add btn-remove'><i class='fa fa-minus' aria-hidden='true'></i></button>");
        }

        return false;

    });

    /* Remover Input Select em Ação Tomada */

    $('.j_ac').on('click', '.j_a', function () {

        var a = document.getElementsByClassName('j_control2').length;

        if (a > 1) {
            $('.j_ac').find('.j_control2').eq(-1).remove();
        }
        if (a == 2) {
            $('.j_a').remove();
        }

        return false;
    });

    /* Scripts relacionados ao input Loja Normalizada */

    $('.j_rst').change(function () {
        var a = $(this).val();

        $('.j_cp').prop('disabled', true);

        if (a == 2) {

            var b = document.getElementsByName('direcionar').length;

            if (b == 0) {
                $('.j_action').append("<label class='j_remove'>Necessidade:</label> <select class='select j_remove j_ch_opt j_disabled_opt form-control' name='direcionar' required><option value=''>Selecione...</option> <option class='j_disable_o' value='2'>Abertura de Chamado Operadora</option><option class='j_disable_t' value='3'>Técnico Regional</option>\n\
			              <option class='j_disable_s' value='4'>SEMEP</option><option value='5'>Restabelecimento de Energia</option><option value='7'>Pagamento de Fatura (Inadiplência)</option></select>");

                $('.j_fer').prop('required', false);
                ctl_prot_op = document.getElementsByClassName('j_prot_op').length;
                j_otrs = document.getElementsByClassName('j_otrs').length;
                j_sisman = document.getElementsByClassName('j_sisman').length;


                if (ctl_prot_op >= 1 && j_otrs >= 1 && j_sisman >= 1) {
                    $('.j_disable_s').prop('disabled', true);
                    $('.j_disable_o').prop('disabled', true);
                    $('.j_disable_t').prop('disabled', true);
                } else if (j_otrs >= 1 && j_sisman >= 1) {
                    $('.j_disable_s').prop('disabled', true);
                    $('.j_disable_t').prop('disabled', true);
                } else if (ctl_prot_op >= 1 && j_sisman >= 1) {
                    $('.j_disable_o').prop('disabled', true);
                    $('.j_disable_s').prop('disabled', true);
                } else if (ctl_prot_op >= 1 && j_otrs >= 1) {
                    $('.j_disable_o').prop('disabled', true);
                    $('.j_disable_t').prop('disabled', true);
                } else if (ctl_prot_op >= 1) {
                    $('.j_disable_o').prop('disabled', true);
                } else if (j_otrs >= 1) {
                    $('.j_disable_t').prop('disabled', true);
                } else if (j_sisman >= 1) {
                    $('.j_disable_s').prop('disabled', true);
                }

            }
        } else if (a == 1) {
            $('.j_remove').remove();
            $('.j_cp').prop('disabled', false);
            $('.j_fer').prop('required', true);
        }
    });


    /* Scripts Relacionados com o Input Necessidade */

    $('.j_action').on('change', '.j_ch_opt', function () {

        var sisman = document.getElementsByClassName('sisman').length;
        var otrs = document.getElementsByClassName('otrs').length;

        //console.log(sisman);
        //console.log(otrs);

        if (sisman >= 1 || otrs >= 1) {
            console.log("ok");
            $('.title-ch').remove();
            $('.sisman').remove();
            $('.otrs').remove();
        }

        if ($(this).val() == 3) {
            $(".j_action").append("<label class='title-ch j_remove'>Chamado OTRS</label> <input required type='text' class='otrs form-control j_remove' name='o_otrs'>");
        } else if ($(this).val() == 4) {
            $(".j_action").append("<label class='title-ch j_remove'>Chamado SISMAN</label> <input required type='text' class='sisman form-control j_remove' name='o_sisman'>");
        }
    });

    /* Variáveis que auxiliam na função TestePing */
    var lk = 1;
    var lk2 = 1;

    /* Teste de ping na ocorrência */
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover() /
                $("div[class*=j_link]").each(function () {
            TestePing();
        });
    });

    var TestePing = function () {
        console.log("ok");
        $.post(urlBaseCh + '/testePing', {ip: $(".j_link" + lk).find("p").eq(2).html()}, function (r) {

            var regExSucess = /Teste Feito com sucesso/;
            var regExFail = /Falha ao fazer o ping/;
            var regExLossPacket = /Perda de pacotes/;

            $('.jImgLoad' + lk2).hide();
            if (regExSucess.test(r)) {
                $(".j_link" + lk2).addClass('online');
                $(".j_link" + lk2).attr('data-content', r);
            } else if (regExFail.test(r)) {
                $(".j_link" + lk2).addClass('offline');
            } else if (regExLossPacket.test(r)) {
                $(".j_link" + lk2).addClass('packetLoss');
            }
            lk2++;
        });
        lk++;
    }

    /* Ação ao clicar em atualizar */
    $('.jrefresh').click(function () {
        lk = 1;
        lk2 = 1;
        var ImgCtl = 1;

        $("div[class*=j_link]").each(function () {
            $('.jImgLoad' + ImgCtl).show();
            if ($('.links').hasClass('online')) {
                $("div[class*=j_link]").removeClass('online');
            } else if ($('.links').hasClass('offline')) {
                $("div[class*=j_link]").removeClass('offline');
            } else if ($('.links').hasClass('packetLoss')) {
                $("div[class*=j_link]").removeClass('packetLoss');
            }
            ImgCtl++;
            TestePing();
        });
    });

    /* Adicionando nota dinamicamente na ocorrência */
    $('.j-btn-nota').click(function () {
        
        var makeData = makedata();
        
        var content = $('.j-new-nota').val();
        var data = makeData['formatUsa'];
        var nome = $('.nome').val();
        var ch = $('.ch').val();

        $.post(urlBaseCh + '/Savenotas', {ch_user: nome, ch_nota: content, ch_time: data, o_cod: ch}, function (r) {
            if (r == 1) {
                $('.ref').after("<div class='col-md-5 nota'>" +
                "<p>" + nome + ", no dia " + makeData['formatBr'] + " disse:</p>" +
                "<p>" + content + "</p>" +
                "</div>");
            }
        });

        $('.j-new-nota').val("");
    });

    function makedata() {
        var data = new Date();
        var y = data.getFullYear();
        var m = data.getMonth() + 1;
        var d = data.getDate();
        var h = data.getHours();
        var mn = data.getMinutes();

        if (m <= 9) {
            m = "0" + m;
        }

        if (d <= 9) {
            d = "0" + d;
        }

        if (h <= 9) {
            h = "0" + h;
        }

        if (mn <= 9) {
            mn = "0" + mn;
        }
        
        var fdate = {
          'formatUsa' :  y + "-" + m + "-" + d + " " + h + ":" + mn,
          'formatBr' : d + "/" + m + "/" + y + " " + h + ":" + mn
        };
                
       return fdate;
    }

});