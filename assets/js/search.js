$(function () {

    $('.j-link-pag').click(function () {

        var totalPag = $('.totalpag').val();
        var Limite = 6;
        var pagina = $('.page-current').attr('href');
        var currentpage = parseInt($('.page-current').attr('href'));

        if ($(this).attr('href') == '+' && currentpage < totalPag) {
            pagina = parseInt(pagina) + 1;
        } else if ($(this).attr('href') == '-' && currentpage > 0) {
            pagina = parseInt(pagina) - 1;
        } else {
            return false;
        }

        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_paginator/definePaginator', {pg: pagina, termo: $('.termo').val(), totalpg: $('.totalpag').val(), action: 'L'}, function (r) {
            
            $('.j-replace').fadeOut(500, function(){
                $('.j-replace').replaceWith(r);
            })
            
            $('.page-current').attr('href', pagina);
            $('.page-current').html(pagina + " de " + totalPag);
        });

        return false;
    });
    
    $('.j-link-pag-ch').click(function () {

        var totalPag = $('.totalpag-ch').val();
        var Limite = 6;
        var pagina = $('.page-current-ch').attr('href');
        var currentpage = parseInt($('.page-current-ch').attr('href'));

        if ($(this).attr('href') == '+' && currentpage < totalPag) {
            pagina = parseInt(pagina) + 1;
        } else if ($(this).attr('href') == '-' && currentpage > 0) {
            pagina = parseInt(pagina) - 1;
        } else {
            return false;
        }

        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/index.php/ShortHand_paginator/definePaginator', {pg: pagina, termo: $('.termo').val(), totalpg: $('.totalpag-ch').val(), action: 'O'}, function (r) {
            
            $('.j-replace-ch').fadeOut(500, function(){
                $('.j-replace-ch').replaceWith(r);
            })
            
            $('.page-current-ch').attr('href', pagina);
            $('.page-current-ch').html(pagina + " de " + totalPag);
        });

        return false;
    });

});


