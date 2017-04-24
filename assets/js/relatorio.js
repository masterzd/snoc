$(function () {
    $('.j-sel-rel').change(function () {
        switch ($(this).val()) {
            case '1':
                $('.j-form-rel').attr('action', 'rel/Geral');
                $('.j-add-el #cont').remove();
                break;
            case '2':
                $('.j-form-rel').attr('action', 'rel/Sms');
                if ($('#cont').length === 0) {
                    $('.j-add-el').append("<div class'col-md-5' id='cont'><p style='margin-top: 2%;'>Informe o numero da loja</p> <input type='number' name='lj_num' min='1' max-'99999' class='form-control input-sm margin-left'></div>");
                }
                break;
            case '3':
                $('.j-form-rel').attr('action', 'rel/Loja');
                if ($('#cont').length === 0) {
                    $('.j-add-el').append("<div class'col-md-5' id='cont'><p style='margin-top: 2%;'>Informe o numero da loja</p> <input type='number' name='lj_num' min='1' max-'99999' class='form-control input-sm margin-left'></div>");
                }
                break;
            case '4':
                $('.j-form-rel').attr('action', 'rel/DispInter');
                $('.j-add-el #cont').remove();
                break;
            case '5':
                $('.j-form-rel').attr('action', 'rel/ProdNoc');
                $('.j-add-el #cont').remove();
                break;
            default :
                $('.j-add-el #cont').remove();
                break;
        }
    });
});


