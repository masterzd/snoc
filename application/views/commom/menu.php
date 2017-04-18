<?php $Priv = $_SESSION['user']['Nv'] == 1 ? 'Administrador' : 'Operador Noc'; 
      $Img =   $_SESSION['user']['Img'] ? $_SESSION['user']['Img'] :'assets/img/Userdefault.png';
?>
<div class="container-fluid menu-fixed">
    <div class="row">
        <div class="col-md-12 menu-top">
            <a href="http://sisnoc.maquinadevendas.corp/CI_SISNOC/menuprincipal"><img src="<?php echo base_url('assets/img/SNOC3.png') ?>" alt="SISNOC LOGO" class="img-responsive custom-nav custom-img"></a>
            <ul class="nav nav-pills custom-nav custom-opc">
                <li role="presentation" class="custom-ancor"><a href="http://sisnoc.maquinadevendas.corp/CI_SISNOC/menuprincipal">Home</a></li>
                <li role="presentation" class="custom-ancor"><a href="http://sisnoc.maquinadevendas.corp/CI_SISNOC/manager">Gerenciamento</a></li>
                <li role="presentation" class="custom-ancor"><a href="#">Relatórios</a></li>
                <li role="presentation" class="custom-ancor"><a href="#">DashBoard</a></li>
                <li role="presentation" class="custom-ancor"><a href="#">ADM</a></li>
                <li role="presentation" class="custom-ancor"><a href="#">Sobre</a></li>
                <li class="custom-ancor"><a href="logoff">Sair</a></li>
            </ul>

            <img src="<?php echo base_url($Img) ?>" title="<?= $_SESSION['user']['Nome'] ?>" class="custom-nav img-responsive user-img">

            <div class="custom-nav info-user esconde">
                <p><?= $_SESSION['user']['Nome'] ?></p>
                <p><?= $Priv ?></p>
            </div>
        </div>
    </div>

    <div class="left col-xs-8 hide menucanvas">				
        <div class="sidebar-nav">
            <img src="<?php echo base_url($Img) ?>" title="<?= $_SESSION['user']['Nome'] ?>" class="custom-nav-offcanvas offcanvas-img-user j_img">

            <div class="custom-nav-offcanvas offcanvas-info-user">
                <p><?= $_SESSION['user']['Nome'] ?></p>
                <p><?= $Priv ?></p>
            </div>

            <ul class="nav nav-pills nav-stacked custom-nav-offcanvas offcanvas-menu">
                <li class="custom-ancor"><a href="http://sisnoc.maquinadevendas.corp/CI_SISNOC/menuprincipal">Home</a></li>
                
                <li class="custom-ancor"><a href="#">Relatórios</a></li>
                <li class="custom-ancor"><a href="#">DashBoard</a></li>
                <li class="custom-ancor"><a href="#">ADM</a></li>
                <li class="custom-ancor"><a href="#">Sobre</a></li>
                <li class="custom-ancor"><a href="logoff">Sair</a></li>
            </ul>
        </div>				
    </div>
</div>