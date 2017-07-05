$(function () {
    var currentUrl = window.location.href;
    var pos = currentUrl.lastIndexOf("consulta");
    currentUrl = currentUrl.substr(0, pos);



    var urlBaseCh = currentUrl + 'index.php/ShortHand_Gerenciamento';
    $(document).ready(function () {
        searchIp();
    });

    $('.j-btn-refresh').click(function () {
        $('.j-reset').attr('src', currentUrl + 'assets/img/loading.gif');
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
                        $('#' + jsonArr.link).attr('src', currentUrl + 'assets/img/green.png');
                    } else if (jsonArr.Resultado == 'Falha ao fazer o ping') {
                        $('#' + jsonArr.link).attr('src', currentUrl + 'assets/img/red.png');
                    } else if (jsonArr.Resultado == 'Perda de pacotes') {
                        $('#' + jsonArr.link).attr('src', currentUrl + 'assets/img/yellow.png');
                    }
                });
    }

    $(document).scroll(function () {
        if ($(this).scrollTop() >= 160) {
            $('.num-loja-help').fadeIn(600);
        } else if ($(this).scrollTop() <= 160) {
            $('.num-loja-help').fadeOut(600);
        }
    });


    $("[name='sms']").bootstrapSwitch({
        size: 'small',
        onText: 'Principal',
        offText: 'Backup'
    });


    var connectRouter = function (idLanRouter) {
        if (idLanRouter == 'P') {
            var ip = $('#' + idLanRouter).html();
        } else {
            var ip = $('#' + idLanRouter).html();
        }

        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter', {ip: ip}, function (retorno) {
            if (retorno == 1) {
                $('.msg-conn').html("Conectado em " + ip);
                $('.j-btn-cmd').removeAttr('disabled');
            } else {
                $('.msg-conn').html("Não foi possível conectar em " + ip);
                $('.j-btn-cmd').attr('disabled', true);
            }
        });

    }

    $('input[name="sms"]').on('switchChange.bootstrapSwitch', function (event, state) {
        $('.msg-conn').html("Conectando no router ...");
        $('.j-btn-cmd').attr('disabled', true);
        if (state == true) {
            connectRouter('P');
        } else {
            connectRouter('B');
        }
    });
    
    var checkActiveRoute = function(){       
        if($('.j-sms').val() == 'on'){
            ip = $('#P').html();
        }else{
            ip = $('#B').html(); 
        }
        
        return ip;
    }

    $(document).ready(function () {
        connectRouter('P');
    });
    
    
    /* Ações dos botões de comando */
    
    $('#Ping').click(function(){
        var ipDest = prompt("Informe o ip para teste");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/ping', {ipDest: ipDest, ipRoute: ipRouter}, function(r){
            $('.j-result').html(r);
        });
        
    });

});

