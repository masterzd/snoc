$(function() {
	/* Script responsável por fazer as interações no Menu do topo */
    
    var callMenu = function (event) {
        var lar = $(window).width();
        
        if(event == undefined){
           var data = 48;
        }else{
            var data = event.swipestart.coords[0];
        }
        
        
        console.log(data);
        
        if (lar >= 501) {
            $('.menucanvas').addClass('hide');
        } else if(data <= 50) {

            $('.menucanvas').removeClass('hide');
            $('.menucanvas').removeClass('left');
            $('.menucanvas').addClass('offcanvas');
            $('body').addClass('block-rolagem');
        }
    }
    
    
	/* Funções JQUERY PARA o MENU-BARRA_TOPO*/
    $(document).on('swiperight', callMenu);
    $('.j-menu-hamburguer').click(function(){
        callMenu();
    });
    
    $(document).on('swipeleft', function () {
        $('.offcanvas').addClass('left');
        $('body').removeClass('block-rolagem');
    });
    
    $('.j-area-remove-offcanvas').click(function(){
        $('.offcanvas').addClass('left');
    })
	
	
	
	
	
});