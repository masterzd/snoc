$(function () {
    var UrlBase = 'http://localhost/CI_SISNOC/';
    /*Funcao Responsável por manter atualizados os dados na tela de operadora*/
    $(document).ready(function () {
        Check();
    });

//Função para disparar o loop pooling para fazer a atualização do dashboard em realtime. 
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
            $.each(json, function (Key, value) {
                $('#' + value[0]).html(value[1]);
            });
            var sum = parseInt($('.card p').eq(0).html()) + parseInt($('.card p').eq(1).html()) + parseInt($('.card p').eq(2).html())
                    + parseInt($('.card p').eq(3).html()) + parseInt($('.card p').eq(4).html());
            $('.card p').eq(5).html(sum);
            Check();
        });
    }
    
    var GeraModal = function(link){
        
      $.post('http://localhost/CI_SISNOC/geraModal', {link: link}, function(tabela){
          
      });  
        
        
    }
    
    $('#0').click()
    


});


