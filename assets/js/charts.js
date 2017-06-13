$(function(){

	$('.j-tpchart').change(function() {
		
		var datetime = "<div class=\"input-daterange input-group\" id=\"datepicker\">\
                            <input type=\"text\" placeholder=\"Informe a data inicial\" title=\"O Formato informad\" required pattern=\"^[0-9]{4}-[0-9]{2}-[0-9]{2}$\" class=\"j-date j-dtIni input-sm form-control col-md-2\" name=\"dataIni\">\
                            <span class=\"input-group-addon\">a</span>\
                            <input type=\"text\" placeholder=\"Informe a data final\" required pattern=\"^[0-9]{4}-[0-9]{2}-[0-9]{2}$\" class=\"j-date j-dtFim input-sm form-control col-md-2\" name=\"dataFim\">\
                        </div>\
						<div class=\"form-group\">\
	                       <button type=\"button\" class=\"btn btn-danger btn-gerar\">Gerar</button>\
	                    </div>\
                        ";
        console.log(datetime);                

		$('.relChart').append(datetime);
	});


$('.relChart').on('focus', '.j-date', function(){
	$(this).datepicker({
        format: 'yyyy-mm-dd',
        language: 'pt-BR',
        orientation: 'bottom auto',
        autoclose: true
     });
});


$('.relChart').on('click', '.btn-gerar', function(){
	
	$.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/anaFalhaLoja', {dataIni: $('.j-dtIni').val(), dataFim: $('.j-dtFim')}, function(retorno) {
		console.log(jQuery.parseJSON(retorno));
	});

});


});