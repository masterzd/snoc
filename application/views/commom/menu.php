<?php
if(empty($_SESSION)):
  session_start();  
endif;
if (empty($_SESSION['user'])):
    $Validation['erro'] = "Sessão Expirada. Fazer login novamente.";
    $this->load->view('login', $Validation);
    die();
endif;
$Priv = $_SESSION['user']['Nv'] == 1 ? 'Administrador' : 'Operador Noc';
?>
<div class="container-fluid menu-fixed">

    <div class="left col-xs-8 hide menucanvas">				
        <div class="sidebar-nav">


            <div class="custom-nav-offcanvas offcanvas-info-user">
                <p><?= $_SESSION['user']['Nome'] ?></p>
                <p><?= $Priv ?></p>
            </div>

            <ul class="nav nav-pills nav-stacked custom-nav-offcanvas offcanvas-menu">
                <li class="custom-ancor"><a href="<?= base_url('menuprincipal') ?>">Home</a></li>
                <li class="custom-ancor"><a href="<?= base_url('relatorios') ?>">Relatórios</a></li>
                <li class="custom-ancor"><a target="_blank" href="<?= base_url('dashboard') ?>">DashBoard</a></li>
                <li class="custom-ancor"><a href="<?= base_url('adm') ?>">ADM</a ></li>
                <li class="custom-ancor"><a href="#">Sobre</a></li>
                <li class="custom-ancor"><a href="logoff">Sair</a></li>
            </ul>
        </div>				
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 menu-top">
            <span class="menu-hamburger j-menu-hamburguer"><i class="fa fa-bars" aria-hidden="true"></i></span>
            <a  href="<?= base_url('menuprincipal') ?>"><img src="<?php echo base_url('assets/img/SNOC3.png') ?>" alt="SISNOC LOGO" class="img-responsive custom-nav custom-img"></a>

            <ul class="nav nav-pills custom-nav custom-opc">
                <li role="presentation" class="custom-ancor"><a href="<?= base_url('menuprincipal') ?>">Home</a></li>
                <li role="presentation" class="custom-ancor"><a href="<?= base_url('manager') ?>">Cadastros</a></li>
                <li role="presentation" class="custom-ancor"><a href="<?= base_url('relatorios') ?>">Relatórios</a></li>
                <li role="presentation" class="custom-ancor"><a target="_blank" href="<?= base_url('dashboard') ?>">DashBoard</a></li>
                <li role="presentation" class="custom-ancor"><a href="<?= base_url('adm') ?>">ADM</a></li>
                <li role="presentation" class="custom-ancor"><a href="#">Sobre</a></li>
                <li class="custom-ancor"><a href="logoff">Sair</a></li>
            </ul>


            <form action="busca" method="POST" class="custom-nav hide-mobo">
                <div class="form-group">
                    <input type="text" name="termo" required="" title="Informe algo para eu pesquisar" class="form-control j-termo-mP" placeholder="Busca rápida.">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </form>
            <div class="custom-nav info-user esconde">
                <p><?= $_SESSION['user']['Nome'] ?></p>
                <p><?= $Priv ?></p>
            </div>
        </div>
    </div>
</div>