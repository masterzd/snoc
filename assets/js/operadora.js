$(function () {
    var UrlBase = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/';
    /*Funcao Responsável por manter atualizados os dados na tela de operadora*/

    /* Função responsável pelas abas */
    $('#Geral').click(function () {
        $('.Geral').removeClass('hidden');
        $('.Filas').addClass('hidden');
    });
    $('#Filas').click(function () {
        $('.Filas').removeClass('hidden');
        $('.Geral').addClass('hidden');
    });




    //Função para disparar o Long Polling para fazer a atualização do dashboard em realtime. 
    var Check = function () {
        var dados = '';
        $('.card .count').each(function () {
            if ($(this).html() === undefined) {
            } else {
                dados += $(this).html();
                dados += '&';
            }
        });

        console.log(dados);
        $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/getUpdate', {info: dados}, function (retorno) {
            var json = jQuery.parseJSON(retorno);
            $.each(json, function (Key, value) {
                $('#' + value[0]).html(value[1]);
            });
            var sum = parseInt($('.card .count').eq(0).html()) + parseInt($('.card .count').eq(1).html()) + parseInt($('.card .count').eq(2).html())
                    + parseInt($('.card .count').eq(3).html());
            $('.card .count').eq(4).html(sum);
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

    var CountTime = function (classe) {
        $.each($('.' + classe), function (key, value) {
            if ($(this).html() != '+ de 35 dias') {
                IncrementTime($(this).html(), $(this).attr('id'));
            }
        });
    }

    var IncrementTime = function (time, id) {

        timeBroken = time.split(":");
        var hora = parseInt(timeBroken[0]);
        var min = parseInt(timeBroken[1]);
        var seg = parseInt(timeBroken[2]);

        seg++;

        if (seg > 59) {
            min++;
            seg = 00;
            if (min > 59) {
                hora++;
                min = 00;
            }
        }

        if (hora <= 9) {
            hora = '0' + hora;
        }

        if (min <= 9) {
            min = '0' + min;
        }

        if (seg <= 9) {
            seg = '0' + seg;
        }

        var tempo = hora + ':' + min + ':' + seg;

        $('#' + id).html(tempo);
    }

    var CheckFilasOperadoras = function () {
        var ch = '';
        $.each($('tr'), function (key, value) {

            if ($(this).attr('id') != undefined) {
                ch += $(this).attr('id');
                ch += '&';
            }
        });

        if (ch == '') {
            setInterval(function () {
                window.location.reload();
            }, 120000);
        } else {
            $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/listenFilas', {info: ch}, function (res) {
                console.log(res);
                var json = jQuery.parseJSON(res);
                $.each(json, function (key, value) {
                    if (value != null) {
                        $('.' + key).html('');
                        $('.' + key).append(value);
                    } else {
                        $('.' + key + '> table > tbody > tr').remove();
                    }
                })
                CheckFilasOperadoras();
            });
        }
    }


    $(document).ready(function () {
        Check();
        CheckFilasOperadoras();
        setInterval(function () {
            CountTime('j-timeab');
        }, 1000);

        setInterval(function () {
            CountTime('j-timeabAdsl');
        }, 1000);
    });

});


