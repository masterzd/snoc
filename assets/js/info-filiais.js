$(function () {
    var urlBaseCh = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_Gerenciamento';
    var ip = null;
    var link = null;
    var ctl = 1;
    
    $(document).ready(function(){
       $('td[class*=Ip_link]').each(function(){
          ip = $(this).text();
          link = $(this).attr('rel');
          TestePing(ip);
       });
    });

   var TestePing = function () {
        $.post(urlBaseCh + '/testePing', {ip: ip, link: link})
         .done(function(result){             
             var jsonArr = jQuery.parseJSON(result);
             
             if(jsonArr.Resultado == 'Teste Feito com sucesso'){
                 $('.'+ jsonArr.link).attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/green.png');
             }else if(jsonArr.Resultado == 'Falha ao fazer o ping'){
                 $('.'+ jsonArr.link).attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/red.png');
             }else if(jsonArr.Resultado == 'Perda de pacotes'){
                 $('.'+ jsonArr.link).attr('src', 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/assets/img/yellow.png');
             }
             
         });
    }
});

