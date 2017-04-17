$(function () {
    var urlBaseCh = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_Gerenciamento';
    $(document).ready(function () {
        searchIp();
    });

    $('.j-btn-refresh').click(function () {
        $('.j-reset').attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/loading.gif');
        searchIp();
    })


    var searchIp = function () {
        $('td[class*=Ip_link]').each(function () {
            TestePing($(this).text(), $(this).attr('rel'));
        });
    }

    var TestePing = function (Ip, Link) {
        $.post(urlBaseCh + '/testePing', {ip: Ip, link: Link})
                .done(function (result) {
                    var jsonArr = jQuery.parseJSON(result);
                    if (jsonArr.Resultado == 'Teste Feito com sucesso') {
                        $('#' + jsonArr.link).attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/green.png');
                    } else if (jsonArr.Resultado == 'Falha ao fazer o ping') {
                        $('#' + jsonArr.link).attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/red.png');
                    } else if (jsonArr.Resultado == 'Perda de pacotes') {
                        $('#' + jsonArr.link).attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/yellow.png');
                    }
                });
    }
});

