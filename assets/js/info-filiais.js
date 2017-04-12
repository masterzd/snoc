$(function () {
    var urlBaseCh = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_Gerenciamento';
    var ip = null;
    
    
    $(document).ready(function(){
       $('td[class*=Ip_link]').each(function(){
          ip = $(this).text();
          TestePing();
       });
    });

   var TestePing = function () {
        $.post(urlBaseCh + '/testePing', {ip: ip}, function (r) {

            var regExSucess = /Teste Feito com sucesso/;
            var regExFail = /Falha ao fazer o ping/;
            var regExLossPacket = /Perda de pacotes/;
            
            
            if (regExSucess.test(r)) {
                $('.switch').attr('src','http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/green.png');
            } else if (regExFail.test(r)) {
                $('.switch').attr('src', '../img/red.png');
            } else if (regExLossPacket.test(r)) {
                $(".j_link" + lk2).addClass('packetLoss');
            }
            $('.switch').removeClass('custom-loading');
            $('.switch').addClass('custom-status');
        });
    }
});

