<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Resultados da Busca - SISNOC</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/menu.css') ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/busca.css') ?>"> 
    </head>
    <body>
        <?php
        session_start();
        if (empty($_SESSION['user'])):
            $Validation['erro'] = "Sessão Expirada. Fazer login novamente.";
            $this->load->view('login', $Validation);
            die();
        endif;
        $this->load->view('commom/menu.php');
        ?>

        <div class="container-fluid">
            <div class="row">
                <header class="col-md-10 header-busca">
                    <h1 class="title-busca">Resultados da Busca</h1>
                    <p class="subTitle-busca">Exibindo resultados para: <?= $Termo ?></p>
                </header>
            </div>
            <div class="row">
                <content class="col-md-10 content-busca">
                    <p class="title-busca-cat">Lojas:</p>
                    <hr class="line">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-custom">
                                <tr class="tb-color">
                                    <th>Loja</th>
                                    <th>Endereço</th>
                                    <th>Bairro</th>
                                    <th>Cidade</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody class="j-replace">
                                <?php
                                foreach ($Lojas as $L):
                                    echo "   
                                     <tr>
                                        <td>{$L['lj_num']}</td>
                                        <td>{$L['lj_end']}</td>
                                        <td>{$L['lj_bairro']}</td>
                                        <td>{$L['lj_cidade']}</td>
                                        <td>{$L['lj_uf']}</td>
                                     </tr>";
                                endforeach;
                                ?> 
                            </tbody>
                        </table>
                    </div>
                    <?php 
          if($Lojas['Count'] > 2):
                    ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                            </li>
                            <?php                            
                                for ($i = 1; $i < $Lojas['Count']; $i++):
                                    if ($i <= 15):
                                        echo "<li class=\"page-item\"><a class=\"page-link j-link-pag\" href=\"{$i}\">{$i}</a></li>";
                                    endif;
                                endfor;
                            ?>

                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Próximo</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
               <?php endif; ?>     
                </content>
            </div>
            <div class="row">
                <content class="col-md-10 content-busca">
                    <p class="title-busca-cat">Ocorrências:</p>
                    <hr class="line">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-custom">
                                <tr class="tb-color">
                                    <th>Ocorrência</th>
                                    <th>Loja</th>
                                    <th>Link</th>
                                    <th>Prazo de Normalização</th>
                                    <th>Aberto por:</th>
                                    <th>Emcaminhado para:</th>
                                    <th>Situação:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($Chamados as $C):
                                    if ($C != NULL):
                                        foreach ($C as $Ch):
                                            switch ($Ch['o_nece']):
                                                case '2':
                                                    $Sit = 'Operadora';
                                                    break;
                                                case '3':
                                                    $Sit = 'Técnico';
                                                    break;
                                                case '4':
                                                    $Sit = 'SEMEP';
                                                    break;
                                                case '5':
                                                    $Sit = 'Falta de Energia';
                                                    break;
                                                default:
                                                    $Sit = 'Sem informações';
                                                    break;
                                            endswitch;

                                            switch ($Ch['o_sit_ch']):
                                                case '0':
                                                case '2':
                                                case '3':
                                                case '4':
                                                case '5':
                                                case '6':
                                                case '7':
                                                    $SitCh = 'Aberto';
                                                    break;
                                                case '8':
                                                    $SitCh = 'Cancelado';
                                                    break;
                                                case '1':
                                                    $SitCh = 'Fechado';
                                                    break;
                                                default :
                                                    $SitCh = 'Sem informações';
                                            endswitch;

                                            echo"
                                        <tr>
                                            <td>{$Ch['o_cod']}</td>
                                            <td>{$Ch['o_loja']}</td>
                                            <td>{$Ch['o_link']}</td>
                                            <td>{$Ch['o_prazo']}</td>
                                            <td>{$Ch['o_opr_ab']}</td>
                                            <td>{$Sit}</td>
                                            <td>{$SitCh}</td>
                                        </tr>";
                                        endforeach;
                                    endif;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>                    
                </content>
            </div>
        </div>
        <input type="hidden" class="termo" value="<?= $Termo ?>">
        <script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/scripts.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/search.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/menu-topo.js') ?>"></script>
    </body>
</html>
