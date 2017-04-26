$(function () {
    var currentUrl = window.location.href;
    var pos =  currentUrl.lastIndexOf("consulta");
    currentUrl = currentUrl.substr(0, pos);
    
    
    
    var urlBaseCh = currentUrl +'index.php/ShortHand_Gerenciamento';
    $(document).ready(function () {
        searchIp();
    });

    $('.j-btn-refresh').click(function () {
        $('.j-reset').attr('src',  currentUrl + 'assets/img/loading.gif');
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
                        $('#' + jsonArr.link).attr('src',  currentUrl + 'assets/img/red.png');
                    } else if (jsonArr.Resultado == 'Perda de pacotes') {
                        $('#' + jsonArr.link).attr('src', currentUrl +'assets/img/yellow.png');
                    }
                });
    }
    
    $(document).scroll(function(){
       if($(this).scrollTop() >= 160){
           $('.num-loja-help').fadeIn(600);
       }else if($(this).scrollTop() <= 160){
           $('.num-loja-help').fadeOut(600);
       }
    });
    
    
});

