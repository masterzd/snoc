<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShortHand_paginator extends CI_Controller {

    private $Offset;
    private $Registros;
    private $Termo;
    private $ResultSet;

    function __construct() {
        parent::__construct();
        $this->load->Model('Crud');
    }

    public function definePaginator() {
        $Pg = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Pg) and ! empty($Pg['pg'])):
            $this->Termo = $Pg['termo'];
            $this->Registros = 6;
            $this->Offset = ($Pg['pg'] - 1) * $this->Registros;

            if ($Pg['action'] == "L"):
                $this->paginaçãoLojas();
                $this->renderPaginator();
            elseif ($Pg['action'] == "O"):
                $this->paginacaoChamados();
                $this->renderPaginatorCh();
            endif;
        endif;
    }

    private function paginaçãoLojas() {
        $QR = "select lj_num, lj_end, lj_bairro, lj_cidade, lj_uf from tb_lojas "
                . "where lj_num = '{$this->Termo}' or lj_end like '%{$this->Termo}%' or lj_bairro like '%{$this->Termo}%' or lj_end like '%{$this->Termo}%' or lj_cidade like '%{$this->Termo}%' LIMIT {$this->Registros} OFFSET {$this->Offset}";
        $T = array('o');
        $D = array('i');
        $this->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $this->ResultSet = $this->Crud->Results['Dados'];
    }

    private function paginacaoChamados() {
        $QR = "select o_cod, o_loja, o_desig, o_link, o_prazo, o_opr_ab, o_nece, o_sit_ch from tb_ocorrencias where (o_cod = '{$this->Termo}' or o_loja = '{$this->Termo}' or o_desig like '{$this->Termo}%') LIMIT {$this->Registros} OFFSET {$this->Offset}";
        $T = array('o');
        $D = array('i');
        $this->Crud->calldb($T, 'SELECT', $D, 0, $QR);
        $this->ResultSet = $this->Crud->Results['Dados'];
    }

    private function renderPaginator() {

        echo "<tbody class='j-replace'>";
        foreach ($this->ResultSet as $L):
            echo" <tr>
                        <td>{$L['lj_num']}</td>
                        <td>{$L['lj_end']}</td>
                        <td>{$L['lj_bairro']}</td>
                        <td>{$L['lj_cidade']}</td>
                        <td>{$L['lj_uf']}</td>
                     </tr>";
        endforeach;
        echo" </tbody>";
    }

    private function renderPaginatorCh() {

        echo "<tbody class='j-replace-ch'>";
        foreach ($this->ResultSet as $Ch):
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

            echo" <tr>
                        <td><a href='http://sisnoc.maquinadevendas.corp/CI_SISNOC/verchamado/?Ch={$Ch['o_cod']}'>{$Ch['o_cod']}</a></td>
                        <td>{$Ch['o_loja']}</td>
                        <td>{$Ch['o_link']}</td>
                        <td>{$Ch['o_prazo']}</td>
                        <td>{$Ch['o_opr_ab']}</td>
                        <td>{$Sit}</td>
                        <td>{$SitCh}</td>
                     </tr>";
        endforeach;
        echo" </tbody>";
    }

}
