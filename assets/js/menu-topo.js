$(function() {
	/* Script responsável por fazer as interações no Menu do topo */
	
	/* Funções JQUERY PARA o MENU-BARRA_TOPO*/
    $(document).on('swiperight', function () {

        var lar = $(window).width();
        console.log(lar);

        if (lar >= 501) {
            $('.menucanvas').addClass('hide');
        } else {

            $('.menucanvas').removeClass('hide');
            $('.menucanvas').removeClass('left');
            $('.menucanvas').addClass('offcanvas');
        }
    });
    $(document).on('swipeleft', function () {
        $('.offcanvas').addClass('left');
    });
	
	
	
	
	
});