$(function () {
    var UrlBase = 'http://localhost/CI_SISNOC/';
    /*Funcao Responsável por manter atualizados os dados na tela de operadora*/
    $(document).ready(function () {
        Check();
    });

    /* Função responsável pelas abas */
    $('#Geral').click(function(){
        $('.Geral').removeClass('hidden');
        $('.Filas').addClass('hidden');
    });
    $('#Filas').click(function(){
        $('.Filas').removeClass('hidden');
        $('.Geral').addClass('hidden');
    });
    
    


    //Função para disparar o Long Polling para fazer a atualização do dashboard em realtime. 
    var Check = function () {
        var dados = '';
        $('.card p').each(function () {
            if ($(this).html() === undefined) {
            } else {
                dados += $(this).html();
                dados += '&';
            }
        });
        

        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/getUpdate', {info: dados}, function (retorno) {
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
    
    
    $('.card p').click(function () {
        GeraModal($(this).attr('id'));
    });
    
    /* Função responsável por buscar os dados e monta o modal */
    var GeraModal = function (id) {
        console.log(id);
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/geraModal', {id: id}, function (tabela) {

            if (tabela == 'fail') {
                alert("Sem resultados a serem exibidos");
            } else {
                $('#Modal').html(tabela);
                $('#Modal').modal('show');
            }
        });
    }

});


