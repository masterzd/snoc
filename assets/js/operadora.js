$(function () {
    var UrlBase = 'http://localhost/CI_SISNOC/';
    /*Funcao Responsável por manter atualizados os dados na tela de operadora*/
    $(document).ready(function () {
        Check();
    });


    var Check = function () {
        var dados = '';
        $('.card p').each(function () {
            if ($(this).html() === undefined) {
            } else {
                dados += $(this).html();
                dados += '&';
            }
        });

        $.post('http://localhost/CI_SISNOC/getUpdate', {info: dados}, function (retorno) {
            var json = jQuery.parseJSON(retorno);
            $.each(json, function(Key, value){
               $('#'+ value[0]).html(value[1]); 
            });
            
            
            
            Check();
        });
        
    }


});


