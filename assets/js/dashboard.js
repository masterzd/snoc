$(function () {

    var UrlBase = 'http://localhost/CI_SISNOC/';

    $('.j-home').click(function () {
        changeScreen(UrlBase + 'home');
    });
    $('.j-oper').click(function () {
        changeScreen(UrlBase + 'relatorios');
    });


    var changeScreen = function (url) {

        $('.obj-panel').fadeOut(500, function () {
            $('.j-obj-panel').attr('data', url);
            $('.obj-panel').fadeIn(1000, function () {
                $('.j-obj-panel').attr('style', '');
            })
        });
    };


    $('.j-ctl-per').change(function () {

        if ($(this).val()) {
            $.post(UrlBase + 'per', {per: $(this).val()}, function (result) {
                if (result) {
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChart);



                    function drawChart() {

                        var dados = [['Lojas', 'Qtd. Ch']];

                        $.each(result, function (key, value) {
                            dados.push([value.o_loja, parseInt(value.count)]);
                        });


                        var data = google.visualization.arrayToDataTable(dados);

                        var options = {
                            title: 'Lojas com mais incidentes gerados',
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);

                    }
                } else {
                    alert("Não foram encontradas informações");
                }


            }, "json");
        }




    });





});


