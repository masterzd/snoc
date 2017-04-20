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
                $('.j-add-el').append("<p>Informe o numero da loja</p> <input type='number' name='lj_num' min='1' max-'99999' class='form-control input-sm'>");
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


