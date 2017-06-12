$(function () {
    /* Script reposável por fazer as interatividades no dashboard */
    var UrlBase = 'http://sisnoc.maquinadevendas.corp/CI_SISNOC/';

    /* Função gerada automaticamente para gerar o gráfico com a opção default de 30 dias */
    $(document).ready(function () {
        geraChart($('.j-ctl-per').val());
        updateHome();
        CheckQt();
    });


    /* Funções que alteram os menus no dashboard */
    $('.j-home').click(function () {
        changeScreen(UrlBase + 'home');
    });
    $('.j-oper').click(function () {
        changeScreen(UrlBase + 'operadora');
    });
    $('.j-tec').click(function () {
        changeScreen(UrlBase + 'tecSemep');
    });
    $('.j-offline').click(function () {
        $('#mdlinfo4').modal('show');
    });
    
    



    /* Função que faz a mudança de tela das opções do dashboard */
    var changeScreen = function (url) {
        $('.obj-panel').fadeOut(500, function () {
            $('.j-obj-panel').attr('data', url);
            $('.obj-panel').fadeIn(1000, function () {
                $('.j-obj-panel').attr('style', '');
            })
        });
    };


    /* Funções relacionada a Geração dos Gráficos - API usada: Google Charts */

    /* Essa função dispara a função que gera o gráfico de acordo com a opção que selecionada no Combobox com a classe j-ctl-per */
    $('.j-ctl-per').change(function () {
        if ($(this).val()) {
            geraChart($(this).val());
        }
    });

    /* Função com a api integrada que faz a chamada e a geração dos Gráficos no formato de Pizza */
    var geraChart = function (vl) {

        if (vl) {
            $.post(UrlBase + 'per', {per: vl}, function (result) {

                if (result) {
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var dados = [];

                        $.each(result, function (key, value) {
                            dados.push([value.o_loja, parseInt(value.count)]);
                        });


                        var data = new google.visualization.DataTable(dados);
                        data.addColumn('string', 'Loja');
                        data.addColumn('number', 'Num. Ch');
                        data.addRows(dados);

                        var options = {
                            title: 'Lojas com mais incidentes gerados',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        function selectHandler() {
                            var selectedItem = chart.getSelection()[0];
                            if (selectedItem) {
                                var value = data.getValue(selectedItem.row, 0);
                                getChamadosChart(value, vl);
                            }
                        }
                        google.visualization.events.addListener(chart, 'select', selectHandler);
                        chart.draw(data, options);

                    }
                } else {
                    alert("Não foram encontradas lojas com incidentes nos ultimos " + vl + " dias/meses");
                }
            }, "json");

        }

    }

    /* A função abaixo é responsável por trazer os chamados quando é feito o click no Gráfico */
    var getChamadosChart = function (loja, per) {
        $.post(UrlBase + 'getChChart', {o_loja: loja, per: per}, function (data) {
            $('.modal-title').html('Ocorrências da Loja: ' + loja);
            $('.modal-body').html(data);
            $('#mdlinfo2').modal('show');
        });
    };

    /* Função responsável por mostrar um modal com as lojas que possuem chamados em aberto */
    $('.lj-inc').click(function () {
        $('#mdlinfo3').modal('show');
    });
    
    /* Função responsável por disparar o loop pooling para atualizar os dados na tela Home*/
    var updateHome = function () {

        var dados = '';

        $.each($('.dadosDash'), function () {
            dados += $(this).html();
            dados += '&';
        });

        $.post(UrlBase + 'homepooling', {dados: dados}, function (res) {
            var JSON = jQuery.parseJSON(res);
            $.each(JSON, function (key, value) {
                switch (key) {
                    case 'CadLj':
                        $('.card p').eq(0).html(value);
                        break;
                    case 'OfflineQT':
                        $('.card p').eq(1).html(value);
                        break;
                    case 'LjInc':
                        $('.card p').eq(2).html(value);
                        break;
                    case 'MPLS':
                        $('.card p').eq(3).html(value);
                        break;
                    case 'ADSL':
                        $('.card p').eq(4).html(value);
                        break;
                    case 'XDSL':
                        $('.card p').eq(5).html(value);
                        break;
                    case 'MB4G':
                        $('.card p').eq(6).html(value);
                    case 'Radio':
                        $('.card p').eq(7).html(value);
                        break;
                    default :
                        console.log('Não Houve alterações');
                        break;
                }
            });
            var table = '';
            $.each(JSON.LjIncArr, function (key, value) {
                if (value.o_loja != undefined) {
                    table += "<tr><td>" + value.o_loja + "</td><td>" + value.Chamados + "</td></tr>";
                }
            });

            $('.rowsTableHome').remove();
            $('#DinamicTable').append(table);

            var tableOff = '';
            $.each(JSON.OfflineArr, function (key, value) {
                if (value.o_loja != undefined) {
                    tableOff += "<tr><td>" + value.o_cod + "</td><td>" + value.o_loja + "</td><td>" + value.o_link + "</td><td>" + value.o_desig + "</td><td>" + value.o_prazo + "</td><td>" + value.o_opr_ab + "</td></tr>";
                }
            });

            $('.rowsTableHomeOffline').remove();
            $('#DinamicTableOffline').append(tableOff);
            
            CheckQt();
            updateHome();
        });
    }
    
    
    var CheckQt = function(){
        if($('.card p').eq(1).html() > 0){
           $('.card p').eq(1).addClass('danger');
        }else{
           $('.card p').eq(1).addClass('normal'); 
        }
    }

});


