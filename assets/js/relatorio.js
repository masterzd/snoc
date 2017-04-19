$(function () {
    $('.j-sel-rel').change(function () {
        switch ($(this).val()) {
            case '1':
                $('.j-form-rel').attr('action', 'rel/Geral');
                break;
            case '2':
                $('.j-form-rel').attr('action', 'rel/Sms');
                break;
            case '3':
                $('.j-form-rel').attr('action', 'rel/Loja');
                break;
            case '4':
                $('.j-form-rel').attr('action', 'rel/DispInter');
                break;
            case '5':
                $('.j-form-rel').attr('action', 'rel/ProdNoc');
                break;
            default :
                alert("Opção Inválida");
                break;
        }
        
        
        
        
    });
});


