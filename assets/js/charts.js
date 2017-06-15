$(function(){

$('.btn-gerar').click(function(){
	
	if($('.j-tpchart').val() == 1){
			
		$.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/falhaOperadora', {dataIni: $('.j-dtIni').val(), dataFim: $('.j-dtFim').val()}, function(retorno) {
			
			if(retorno == 'Falha'){
				alert('Sem informações para a estatística');
			}else{
			    chartFalhaOperadora(jQuery.parseJSON(retorno), 'Falhas por parte da Operadora');
			}
		});	
	}else if($('.j-tpchart').val() == 2){
		$.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/falhaInterna', {dataIni: $('.j-dtIni').val(), dataFim: $('.j-dtFim').val()}, function(retorno) {
			
			if(retorno == 'Falha'){
				alert('Sem informações para a estatística');
			}else{
				chartFalhaOperadora(jQuery.parseJSON(retorno), 'Falhas por problemas internos');
			}
			
		});
	}else if($('.j-tpchart').val() == 3){
		$.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/falhaResp', {dataIni: $('.j-dtIni').val(), dataFim: $('.j-dtFim').val()}, function(retorno) {
			
			if(retorno == 'Falha'){
				alert('Sem informações para a estatística');
			}else{
				chartResponsabilidade(jQuery.parseJSON(retorno));
			}
		});
	}else if($('.j-tpchart').val() == 4){
		console.log("ok");
		$.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/topLojas', {dataIni: $('.j-dtIni').val(), dataFim: $('.j-dtFim').val()}, function(retorno) {
			if(retorno == 'false'){
				alert('Sem informações para a estatística');
			}else{
				ChartPeriodoLojas(jQuery.parseJSON(retorno));
			}			
		});
	}





});


var chartFalhaOperadora = function(jsonObj, title){

	  google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      var dados = [];

      $.each(jsonObj, function(key, value) {
      		dados.push([value.o_causa_prob, parseInt(value.quantidade)]);
      });

      function drawStuff() {
         var data = new google.visualization.DataTable(dados);
         data.addColumn('string', 'Causa do Problema');
         data.addColumn('number', 'Quantidades');
         data.addRows(dados);

         var options = {
            title: title,
           	bars: 'horizontal', // Required for Material Bar Charts.
	        axes: {
	            x: {
	              0: { side: 'top', label: title} // Top x-axis.
	            }
	         },
	        bar: { groupWidth: "90%" },
	        width: '900',
            height: '300',
          	backgroundColor: '#fcfbe0',
         };


        var chart = new google.charts.Bar(document.getElementById('chart'));
        // Convert the Classic options to Material options.
        chart.draw(data, options);
      };

	}	

var chartResponsabilidade = function(jsonObj){

	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawStuff);

      var dados = [];

      $.each(jsonObj, function(key, value) {
      		dados.push([key, parseInt(value)]);
      });

      function drawStuff() {
         var data = new google.visualization.DataTable(dados);
         data.addColumn('string', 'Causa do Problema');
         data.addColumn('number', 'Quantidades');
         data.addRows(dados);

         var options = {
            title: 'Responsabilidades das Ocorrências',
            is3D: true,
            width: '900',
            height: '300',
            colors: ['red', 'yellow']
         };


        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        // Convert the Classic options to Material options.
        chart.draw(data, options);
      };

}

var ChartPeriodoLojas = function(result){
     
	 google.charts.load('current', {'packages': ['corechart']});
     google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    	console.log(result);
        var dados = [];

        $.each(result, function (key, value) {
            dados.push([value.o_loja, parseInt(value.count)]);
        });

        console.log(dados);

        var data = new google.visualization.DataTable(dados);
        data.addColumn('string', 'Loja');
        data.addColumn('number', 'Num. Ch');
        data.addRows(dados);

        var options = {
            title: 'Lojas com mais incidentes gerados',
            is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        chart.draw(data, options);

    }


}




});