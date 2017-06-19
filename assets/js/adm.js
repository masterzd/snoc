$(function () {
    $("[name='sms']").bootstrapSwitch({
        size: 'small'
    });
    
   $('input[name="sms"]').on('switchChange.bootstrapSwitch', function(event, state){
      $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/admSmsEmail', {status: state, info: $(this).attr('class')}, function(retorno){
            console.log(retorno);
      });
   });
   
   $('.j-busca-o').click(function(){
       if($('.j-num').val() != ''){
           window.open('http://sisnoc.maquinadevendas.corp/CI_SISNOC/ajustesOcorrencias/?Ch='+$('.j-num').val(), '_blank', "width=500, height=360, top=100, left=110, scrollbars=no");
       }else{
           alert('Informe o numero da Ocorrência!!');
       }
   });
   
   
   
   
});


