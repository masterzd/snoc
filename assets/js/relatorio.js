$(function () {
    $('.j-sel-rel').change(function () {
        switch ($(this).val()) {
            case '1':
                $('.j-form-rel').attr('action', 'rel/Geral');
                $('.j-add-el #cont').remove();
                 if ($('#sit-oc').length === 0) {
                   $('.j-add-el').append("<div class'col-md-5' id='sit-oc'><p style='margin-top: 2%;'>Situação da Ocorrência</p> <select required class='form-control j-sit-ch' name='sit-ch'><option value=''>Selecione...</option><option value='1'>Aberto</option><option value='2'>Fechado</option><option value='3'>Todos</option></select></div>");
                 }
                break;
            case '2':
                $('.j-form-rel').attr('action', 'rel/Sms');
                if ($('#cont').length === 0) {
                    $('.j-add-el').append("<div class'col-md-5' id='cont'><p style='margin-top: 2%;'>Informe o numero da loja</p> <input type='text' pattern=\"^[0-9]{4,5}$\" title='O numero da loja é inválido. Normalmente o numero da loja é composto por 4 números' name='lj_num' class='form-control input-sm margin-left'></div>");
                }
                $('#sit-oc').remove();
                break;
            case '3':
                $('.j-form-rel').attr('action', 'rel/Loja');
                if ($('#cont').length === 0) {
                    $('.j-add-el').append("<div class'col-md-5'  id='cont'><p style='margin-top: 2%;'>Informe o numero da loja</p> <input  type='text' pattern=\"^[0-9]{4,5}$\" title='O numero da loja é inválido. Normalmente o numero da loja é composto por 4 números' name='lj_num' class='form-control input-sm margin-left'></div>");
                }
                if ($('#sit-oc').length === 0) {
                    $('.j-add-el').append("<div class'col-md-5' id='sit-oc'><p style='margin-top: 2%;'>Situação da Ocorrência</p> <select required class='form-control j-sit-ch' name='sit-ch'><option value=''>Selecione...</option><option value='1'>Aberto</option><option value='2'>Fechado</option><option value='3'>Todos</option></select></div>");
                }
                break;
            case '4':
                $('.j-form-rel').attr('action', 'rel/DispInter');
                $('.j-add-el #cont').remove();
                $('#sit-oc').remove();
                break;
            case '5':
                $('.j-form-rel').attr('action', 'rel/ProdNoc');
                $('.j-add-el #cont').remove();
                $('#sit-oc').remove();
                break;
            default :
                $('.j-add-el #cont').remove();
                $('#sit-oc').remove();
                break;
        }
    });
});


