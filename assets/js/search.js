$(function(){
   
    $('.j-link-pag').click(function(){
        
      $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_paginator/definePaginator', {pg: $(this).attr('href'), termo: $('.termo').val()}, function(r){
          $('.j-replace').replaceWith(r);
      })

      return false;  
    });

});


