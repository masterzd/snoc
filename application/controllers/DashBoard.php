<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DashBoard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Crud');
        $this->load->helper('url');
    }

    public function Inicio() {
        $this->load->view('dashboard');
    }

    public function Home() {


        $QR1 = "SELECT lj_num from tb_lojas WHERE lj_sit NOT LIKE 'Fechada'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR1);
        $lojasCad = $this->Crud->Results['lines'] ?? 0;

        $QR2 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'MPLS' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
        $MPLS = $this->Crud->Results['lines'] ?? 0;

        $QR3 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'ADSL' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR3);
        $ADSL = $this->Crud->Results['lines'] ?? 0;

        $QR4 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'XDSL' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR4);
        $XDSL = $this->Crud->Results['lines'] ?? 0;

        $QR5 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'IPConnect' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR5);
        $IpCon = $this->Crud->Results['lines'] ?? 0;

        $QR6 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = '4G' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR6);
        $mb4g = $this->Crud->Results['lines'] ?? 0;

        $QR7 = "select cir_link FROM tb_lojas, tb_circuitos where cir_link = 'Radio' AND lj_sit NOT LIKE 'Fechada' AND lj_num = cir_loja";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR7);
        $radio = $this->Crud->Results['lines'] ?? 0;

        $QR = "SELECT DISTINCT o_loja FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 7";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $Inc = $this->Crud->Results['lines'] ?? 0;



        $Dados = [
            'MPLS' => $MPLS,
            'ADSL' => $ADSL,
            'XDSL' => $XDSL,
            'IPCon' => $IpCon,
            'MB4G' => $mb4g,
            'Radio' => $radio,
            'LjInc' => $Inc,
            'CadLj' => $lojasCad
        ];


        $this->load->view('dashboard/home', $Dados);
    }

    public function periodoTopLojas() {

        $Per = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Per) and !empty($Per['per'])):
            
            
            if($Per['per'] == '30' or $Per['per'] == '60' or $Per['per'] == '90'):
                $Data = date('Y-m-d', strtotime("-{$Per['per']} days"));
            else:
                $Data = date('Y-m-d', strtotime("-{$Per['per']} month"));
            endif;
            
            
            $CurrentDate = date("Y-m-d");
            $QR = "select distinct o_loja,(select count(*) from tb_ocorrencias where o_loja = ch.o_loja) as count from tb_ocorrencias as ch where o_hr_ch between '{$Data} 00:00:00' and '{$CurrentDate} 23:59:59' order by count DESC LIMIT 10";
            $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
           
            
            if ($this->Crud->Results['lines'] >= 1):
                echo json_encode($this->Crud->Results['Dados']);
            else:
                echo 'false';
            endif;
        else:
            echo "false";

        endif;
    }

}
