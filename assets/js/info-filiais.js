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
        $('.j-result').html("");
        if (idLanRouter == 'P') {
            var ip = $('#' + idLanRouter).html();
        } else {
            var ip = $('#' + idLanRouter).html();
        }

        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter', {ip: ip}, function (retorno) {           
            if (retorno == '2') {
                $('.msg-conn').html("Falha ao autenticar em <b>" +ip+"</b>");
                $('.j-btn-cmd').attr('disabled', true);
            } else if(retorno == '1') {
                $('.msg-conn').html("Não foi possível conectar em " + ip);
                $('.j-btn-cmd').attr('disabled', true);
            }else if(retorno == '3'){
                 $('.msg-conn').html("Conectado em <b>" +ip+"</b>");
                 $('.j-btn-cmd').removeAttr('disabled');
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

    var checkActiveRoute = function () {
        if ($('.j-sms').val() == 'on') {
            ip = $('#P').html();
        } else {
            ip = $('#B').html();
        }

        return ip;
    }

    $(document).ready(function () {
        connectRouter('P');
    });


    /* Ações dos botões de comando */

    $('#Ping').click(function () {
        var ipDest = prompt("Informe o ip para teste");
        $('.j-result').html("Realizando teste ...");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/ping', {ipDest: ipDest, ipRoute: ipRouter}, function (r) {

            if (r != '') {
                $('.j-result').html(r);
            } else {
                $('.j-result').html("Não Houve resposta para o IP informado");
            }
        });

    });
    
    
    $('#ARP').click(function(){
        $('.j-result').html("Enviando comando ...");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/arp', {ipRouter: ipRouter}, function(r){
            $('.j-result').html(r);
        });
        
    });
    
    
    $('#BGP').click(function(){
       $('.j-result').html("Enviando comando ...");
       var ipRouter = checkActiveRoute();
       $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/bgp', {ipRouter: ipRouter}, function(r){
          $('.j-result').html(r); 
       });
    });
    
    
    $('#INT').click(function(){
        $('.j-result').html("Enviando comando ...");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/int', {ipRouter: ipRouter}, function(r){
            $('.j-result').html(r);
        });
    });
    
    $('#NEI').click(function(){
        $('.j-result').html("Enviando comando ...");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/nei', {ipRouter: ipRouter}, function(r){
            $('.j-result').html(r);
        });
    });
    
    $('#TOPTK').click(function(){
        $('.j-result').html("Enviando comando ...");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/topTalkers', {ipRouter: ipRouter}, function(r){
            $('.j-result').html(r);
        });
    });
    
    $('.j-result').on('click', '.j-interface',function(){
        $('.j-result').html("Enviando comando ...");
        var ipRouter = checkActiveRoute();
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/intDetail', {ipRouter:ipRouter, interface: $(this).attr('id')}, function(r){
            $('.j-result').html(r);
        })
    });
    
    $('#CMD').click(function (){
         var ipRouter = checkActiveRoute();
         var cmd = prompt("ATENÇÂO!!!!\n\n Essa opção possui funcionalidade limitada, pois alguns comandos funcionarão melhor estando conectado diretamente no roteador. \n\n\n Informe abaixo o comando que deseja executar:");
         $('.j-result').html("Enviando comando ...");
         $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/conectRouter/cmd', {ipRouter:ipRouter, command: cmd}, function(r){
            $('.j-result').html(r);
        })
    })
    
});

