$(function () {
    /* Script reposável por fazer as interatividades no dashboard */
    var UrlBase = 'http://localhost/CI_SISNOC/';
    
    /* Função gerada automaticamente para gerar o gráfico com a opção default de 30 dias */
    $(document).ready(function () {
        geraChart($('.j-ctl-per').val());
    });
    

    /* Funções que alteram os menus no dashboard */
    $('.j-home').click(function () {
        changeScreen(UrlBase + 'home');
    });
    $('.j-oper').click(function () {
        changeScreen(UrlBase + 'operadora');
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
        $.post(UrlBase + 'getChChart', {o_loja: loja, per: per}, function(data) {
        $('.modal-title').html('Ocorrências da Loja: ' + loja);
                $('.modal-body').html(data);
                $('#mdlinfo2').modal('show');
        });
    };

    /* Função responsável por mostrar um modal com as lojas que possuem chamados em aberto */
    $('.lj-inc').click(function () {
        $('#mdlinfo3').modal('show');
    });

});


