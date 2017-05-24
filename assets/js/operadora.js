$(function(){
    var UrlBase = 'http://localhost/CI_SISNOC/';
        /*Funcao Responsável por manter atualizados os dados na tela de operadora*/
    $(document).ready(function(){
       window.setInterval(function(){
           
       }, 10000);
    });
    
    
    var Check = function(){       
        $.post( UrlBase + 'getUpdate', function(retorno){
            console.log(retorno);
        });
    }
    
    
});


