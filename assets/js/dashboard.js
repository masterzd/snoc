$(function () {

    var UrlBase = 'http://localhost/CI_SISNOC/';

    $('.j-home').click(function () {
        changeScreen(UrlBase + 'home');
    });
    $('.j-oper').click(function () {
        changeScreen(UrlBase + 'relatorios');
    });


    $(document).ready(function(){
       geraChart($('.j-ctl-per').val());
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
           geraChart($(this).val());
        }
    });





var geraChart = function(value){

     if(value){
        $.post(UrlBase + 'per', {per: value}, function (result) {
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
                              alert('The user selected ' + value);
                            }
                          }

                        google.visualization.events.addListener(chart, 'select', selectHandler);  

                        chart.draw(data, options);

                    }
                } else {
                    alert("Não foram encontradas lojas com incidentes nos ultimos " + value + " dias/meses");
                }


            }, "json");

     }   


     


}



});


