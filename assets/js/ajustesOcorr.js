$(function(){
    $('.j_link').change(function(){
        $('.j-ajustes').html("");
        switch ($(this).val()){
            case '1':
                $('.j-ajustes').append(link);
                break;
            case '2':
                $('.j-ajustes').append(desig);
                break;
            case '3':
                $('.j-ajustes').append(situacao);
                break;
            case '4':
                 $('.j-ajustes').append(prazoNormalizacao);
                break;
            case '5':
                $('.j-ajustes').append(horaIncidente);
                break;
            case '6':
                $('.j-ajustes').append(protocolo);
                break;
            case '7':
                $('.j-ajustes').append(status);
                break;
            case '8':
                $('.j-ajustes').append(necessidade);
                break;
        }
        
    });
    
    $('.j-ajustes').on('click','.j-data', function(){
         $('.j-data').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language: 'pt-BR'
        });
    });
    
    $('.j-sv').click(function(){ 
       var info = document.getElementsByClassName('j-field').length;
       if(info > 0){
           var info = $('.j-field').val();
           if(info == ""){
               alert("Preencha o campo com as informações a ser salvas!");
           }else{
                $.post('http://sisnoc.maquinadevendas.corp/CI_SISNOC/UpdateOc', {o_cod: $('.ocorrencia').val(), $(".field").attr('')});
           }
       }else{
           alert("Escolha uma opção antes de salvar!!");
       }
    });
    
    
    
    
    var link = "<div class=\"form-group col-md-3 col-xs-11\">\
                    <select required name=\"o_link\" id=\"link\" class=\"form-control j-field\" name='o_link' >\
                        <option value=\"\">Informe o link...</option>\
                        <option value=\"MPLS\">MPLS</option>\
                        <option value=\"ADSL\">ADSL</option>\
                        <option value=\"XDSL\">XDSL</option>\
                        <option value=\"IPConnect\">IPConnect</option>\
                    </select>\
                </div>";
    
    var desig = "<div class=\"form-group col-md-3 col-xs-11\">\
                <input type=\"text\" class=\"form-control uppercase j-field\" name=\"o_desig\" placeholder=\"Informe aqui\">\
                </div>";
    
    var protocolo = "<div class=\"form-group col-md-3 col-xs-11\">\
                        <input type=\"text\" class=\"form-control j-field\" name=\"o_prot_op\" placeholder=\"Informe aqui\">\
                    </div>";
    
    var status = "<div class=\"form-group col-md-3 col-xs-11\">\
                    <select required name=\"o_link\" id=\"link\" class=\"form-control j-field\" name='o_status'>\
                        <option value=\"\">Selecione...</option>\
                        <option value=\"Funcionando MPLS\">Funcionando MPLS</option>\
                        <option value=\"Funcionando ADSL\">Funcionando ADSL</option>\
                        <option value=\"Funcionando XDSL\">Funcionando XDSL</option>\
                        <option value=\"Funcionando 4G\">Funcionando 4G</option>\
                    </select>\
                </div>";
    
    var situacao = "<div class=\"form-group col-md-3 col-xs-11\">\
                    <select required name=\"o_link\" id=\"link\" class=\"form-control j-field\" name='o_sit_ch'>\
                        <option value=\"\">Selecione...</option>\
                        <option value=\"1\">Fechado</option>\
                        <option value=\"2\">Abertura Operadora</option>\
                        <option value=\"6\">Pré-Fechamento</option>\
                        <option value=\"8\">Cancelamento</option>\
                    </select>\
                </div>";
    
    var necessidade = "<div class=\"form-group col-md-3 col-xs-11\">\
                    <select required name=\"o_link\" id=\"link\" class=\"form-control j-field\" name='o_nece'>\
                        <option value=\"\">Selecione...</option>\
                        <option value=\"2\">2 - Abertura Operadora</option>\
                        <option value=\"3\">3 - Técnico Regional</option>\
                        <option value=\"4\">4 - SEMEP</option>\
                        <option value=\"5\">5 - Falta de Energia</option>\
                        <option value=\"7\">7 - Inadiplência</option>\
                    </select>\
                </div>";
    
    var prazoNormalizacao = "<div class=\"form-group col-md-3 col-xs-11\">\
                            <input type=\"text\" class=\"form-control j-field j-data\" name=\"o_prazo\" title=\"Informe aqui\">\
                        </div>";
    
    var horaIncidente = "<div class=\"form-group col-md-3 col-xs-11\">\
                            <input type=\"text\" class=\"form-control j-field j-data\" name=\"o_hr_dw\" title=\"Informe aqui\">\
                        </div>";
    
    
})


