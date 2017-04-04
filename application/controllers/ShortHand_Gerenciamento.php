<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShortHand_Gerenciamento extends CI_Controller {
    /*
     * Classe dedicada para funcões que usam Ajax ou post via Js 
     * Autor: Henrique Rocha      
     */

    /*     * ********************************************** */
    /*     * *** Funções de Gerenciamento de usuários ***** */
    /*     * ********************************************* */

    /* Busca de usuários */

    public function shorthand() {

        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Dados)):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_usuarios', 'SELECT', $Dados);
            $Exe = $this->Crud->Results;

            if (is_array($Exe)):
                $Result = $Exe;
            else:
                $Result = FALSE;
            endif;
            echo json_encode($Result);

        endif;
    }

    /* Apaga Usuários */

    public function del() {

        $DadosDel = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($DadosDel) and ! empty($DadosDel['u_user'])):

            $this->load->Model('Crud');
            $Arr = array('u_user' => $DadosDel['u_user']);
            $this->Crud->calldb('tb_usuarios', 'DELETE', $Arr);
            $Exe = $this->Crud->Results;

            if (is_array($Exe)):
                echo json_encode($Exe['rows']);
            else:
                echo json_encode($Exe);
            endif;
        endif;
    }

    /* Inserir Usuário */

    public function insereUsuario() {

        $UserDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($UserDados['dados']) and ! empty($UserDados['dados']['u_nome'])):
            $this->load->Model('Crud');

            $Arr = [
                'u_user' => $UserDados['dados']['u_user']
            ];

            $this->Crud->calldb('tb_usuarios', 'SELECT', $Arr);
            $Consulta = $this->Crud->Results;

            if (is_array($Consulta)):
                echo "existe";
            elseif ($UserDados['dados']['u_senha'] != $UserDados['dados']['u_senha2']):
                echo "pass";
            else:

                $UserDados['dados']['u_senha'] = sha1($UserDados['dados']['u_senha']);
                unset($UserDados['dados']['u_senha2']);
                $this->Crud->calldb('tb_usuarios', 'INSERT', $UserDados['dados']);
                $Ins = $this->Crud->Results;

                if ($Ins == true):
                    echo "success";
                elseif ($Ins == false):
                    echo "falha-01";
                endif;
            endif;
        endif;
    }

    /* Atualiza dados dos usuários */

    public function updateUsuario() {

        $UserUpdateDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        unset($UserUpdateDados['dados']['edit']);
        if (!empty($UserUpdateDados['dados']['u_senha']) or ! empty($UserUpdateDados['dados']['u_senha2'])):
            if ($UserUpdateDados['dados']['u_senha'] != $UserUpdateDados['dados']['u_senha2']):
                die('pass');
            else:
                $UserUpdateDados['dados']['u_senha'] = sha1($UserUpdateDados['dados']['u_senha']);
            endif;
        endif;

        unset($UserUpdateDados['dados']['u_senha2']);
        $this->load->Model('Crud');
        $where = array('u_cod' => $UserUpdateDados['dados']['u_cod']);
        $this->Crud->calldb('tb_usuarios', 'UPDATE', $UserUpdateDados['dados'], $where);
        $Exe = $this->Crud->Results;

        if ($Exe == true):
            echo 'done';
        else:
            echo 'falha-01';
        endif;
    }

    /*     * ********************************************** */
    /*     * ***  Funções de Gerenciamento de Lojas  ***** */
    /*     * ********************************************* */

    /* Busca de Lojas */

    public function buscalojas() {
        $Loja = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Loja) and ! empty($Loja['lj_num'])):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_lojas', 'SELECT', $Loja);
            $Exe = $this->Crud->Results;
            echo json_encode($Exe);
        endif;
    }

    /* Apagar de Lojas */

    public function delLojas() {
        $CodLoja = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($CodLoja) and ! empty($CodLoja['lj_cod'])):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_lojas', 'SELECT', $CodLoja);
            $Res1 = $this->Crud->Results;

            if (!empty($Res1['Dados'][0]['lj_num'])):
                $CondApg = array('cir_loja' => $Res1['Dados'][0]['lj_num']);
                $this->Crud->calldb('tb_circuitos', 'DELETE', $CondApg);
                $this->Crud->calldb('tb_lojas', 'DELETE', $CodLoja);
            endif;
            $Exe = $this->Crud->Results;
            if (is_array($Exe)):
                echo json_encode($Exe);
            else:
                echo false;
            endif;
        endif;
    }

    /* Cadastrar Lojas */

    public function insertLoja() {
        $DadosLoja = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($DadosLoja) and ! empty($DadosLoja['loja']['lj_num'])):
            /* Checa se já existe cadastro da loja */
            $this->load->Model('Crud');
            $Loja = array('lj_num' => $DadosLoja['loja']['lj_num']);
            $this->Crud->calldb('tb_lojas', 'SELECT', $Loja);
            $Res = $this->Crud->Results;

            if (!empty($Res['lines']) and $Res['lines'] >= 1):
                die('existe-cad');
            else:
                /* Efetuando o cadastro da loja */
                $this->Crud->calldb('tb_lojas', 'INSERT', $DadosLoja['loja']);
                $Grv = $this->Crud->Results;
                if ($Grv == true):
                    echo "salvo";
                else:
                    echo "erro";
                endif;
            endif;
        endif;
    }

    /* Atualizar cadastro de lojas */

    public function updateLoja() {
        $UpdateDados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $Where = array('lj_cod' => $UpdateDados['loja']['lj_cod']);
        unset($UpdateDados['loja']['lj_cod']);
        if (!empty($UpdateDados) and ! empty($UpdateDados['loja'])):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_lojas', 'UPDATE', $UpdateDados['loja'], $Where);
            $Resultado = $this->Crud->Results;
            echo $Resultado;
        else:
            echo 'false';
        endif;
    }

    /* Visualizar links cadastrados na loja */

    public function checklink() {

        if (!empty($this->input->get('loja'))):
            $Loja = array('cir_loja' => $this->input->get('loja'));
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_circuitos', 'SELECT', $Loja);
            $Result = $this->Crud->Results;
            $this->load->view('checkLink', $Result);
        else:
            die("Erro Localizar os dados!!");
        endif;
    }

    /* Adicionar Link da Loja cadastrada */

    public function cadastraLink() {
        $Link = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Link) and ! empty($Link['cir_loja'])):
            $Link = array_map('strtoupper', $Link);
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_circuitos', 'INSERT', $Link);
            $Retorno = $this->Crud->Results;
        else:
            $Retorno = "falha-dados";
        endif;
        echo json_encode($Retorno);
    }

    /* Atualizar os dados dos links das lojas */

    public function atualizaLink() {
        $Link = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($Link) and ! empty($Link['Link'])):

            $this->load->Model('Crud');
            $Where = array('cir_cod' => $Link['Link']['cir_cod']);
            $DivNum = $Link['Link']['id-div'];
            unset($Link['Link']['cir_cod'], $Link['Link']['id-div']);
            $this->Crud->calldb('tb_circuitos', 'UPDATE', $Link['Link'], $Where);
            $Res = $this->Crud->Results;

            if ($Res == true):
                echo $DivNum;
            else:
                echo "erro";
            endif;

        endif;
    }

    /* Remover Link da Loja */

    public function removeLink() {
        $Cod = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Cod) and ! empty($Cod['cir_cod'])):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_circuitos', 'DELETE', $Cod);
            $Result = $this->Crud->Results;
            echo json_encode($Result);
        endif;
    }

    /* Ping no link da Loja */

    public function testePing() {
        $IP = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IP) and ! empty($IP['ip'])):

            $CheckOS = preg_match('/(Win64)/', $_SERVER['SERVER_SOFTWARE']);
        
           
        
            if ($CheckOS):
                exec("ping {$IP['ip']}", $output, $return_var);
            else:
                exec("ping -w1 -i 0.2 -c 4 {$IP['ip']} ", $output, $return_var);
            endif;

            
            
            if (count($output)):
                $Saida = array_map('trim', $output);
                $ICMP1 = (preg_match('/Resposta/', $Saida[2]) ? true : (preg_match('/64 bytes/', $Saida[1]) ? true : false));
                $ICMP2 = (preg_match('/Resposta/', $Saida[3]) ? true : (preg_match('/64 bytes/', $Saida[2]) ? true : false));
                $ICMP3 = (preg_match('/Resposta/', $Saida[4]) ? true : (preg_match('/64 bytes/', $Saida[3]) ? true : false));
                $ICMP4 = (preg_match('/Resposta/', $Saida[4]) ? true : (preg_match('/64 bytes/', $Saida[4]) ? true : false));
                $PingResult = "";
                foreach ($Saida as $Result):
                    $PingResult = $PingResult . "\n" . $Result;
                endforeach;
                if ($ICMP1 == TRUE AND $ICMP2 == TRUE AND $ICMP3 == TRUE AND $ICMP4 == TRUE):
                    echo "Teste Feito com sucesso. Segue abaixo o resultado do Ping: \n" . $PingResult;
                elseif ($ICMP1 == FALSE AND $ICMP2 == FALSE AND $ICMP3 == FALSE AND $ICMP4 == FALSE):
                    echo "Falha ao fazer o ping. Segue abaixo o resultado do Ping: \n" . $PingResult;
                else:
                    echo "Perda de pacotes. Segue abaixo o resultado do Ping: \n" . $PingResult;
                endif;
            else:
                echo"O IP informado não é válido.";
            endif;
        else:
            echo"Dados Inválidos";
        endif;
    }

    /*     * ********************************************** */
    /*     * ***  Funções de Gerenciamento de Regionais **** */
    /*     * ********************************************* */


    /* Busca Regionais */

    public function buscaRegionais() {
        $this->load->Model('Crud');
        $this->Crud->calldb('tb_regional', 'SELECT');
        $Regionais = $this->Crud->Results;
        echo json_encode($Regionais['Dados']);
    }

    public function tecCad() {
        $IdResp = (int) $this->input->get('cod');
        if ($IdResp == NULL):
            $this->load->view('tec-cad');
        else:
            $this->load->Model('Crud');
            $Where = array('resp_cod' => $IdResp);
            $this->Crud->calldb('tb_resp_tec', 'SELECT', $Where);
            $ArrTec = $this->Crud->Results;
            $this->load->view('tec-cad', $ArrTec);
        endif;
    }

    /* Buscar informações da Regional selecionada */

    public function infoRegionais() {

        $Reg = filter_input_array(INPUT_POST, FILTER_VALIDATE_INT);
        if (!empty($Reg) and ! empty($Reg['nReg']) and is_int($Reg['nReg'])):
            $this->load->Model('Crud');
            /* Consulta de Regionais */
            $Tabela = array('tb_regional', 'tb_rel_reg', 'tb_lojas');
            $FullQuery = "SELECT * from tb_regional, tb_rel_reg, tb_lojas where tb_regional.r_num = {$Reg['nReg']} and tb_rel_reg.rel_reg = {$Reg['nReg']} and tb_lojas.r_cod = {$Reg['nReg']}";
            $this->Crud->calldb($Tabela, 'SELECT', $Reg, null, $FullQuery);
            $Res01 = $this->Crud->Results;

            if (is_array($Res01)):
                $gerRegCtl = 0;
                $dirRegCtl = 0;
                $arrDadosRegionais = [];

                foreach ($Res01['Dados'] as $Info):
                    if ($gerRegCtl == 0 and preg_match('/GR/', $Info['rel_user']) == true):
                        $Arr = array('gr_rel' => $Info['rel_user']);
                        $this->Crud->calldb('tb_ger_reg', 'SELECT', $Arr);
                        $GerReg = $this->Crud->Results;
                        $arrDadosRegionais['GerenteRegional'] = $GerReg['Dados'][0];
                        $gerRegCtl++;
                    endif;
                    if ($dirRegCtl == 0 and preg_match('/DR/', $Info['rel_user']) == true):
                        $ArrD = array('dr_rel' => $Info['rel_user']);
                        $this->Crud->calldb('tb_dir_reg', 'SELECT', $ArrD);
                        $DirReg = $this->Crud->Results;
                        $arrDadosRegionais['DiretorRegional'] = $DirReg['Dados'][0];
                        $dirRegCtl++;
                    endif;
                    $arrDadosRegionais['lojas'][] = $Info['lj_num'] . "#" . $Info['lj_uf'] . "#" . $Info['lj_cidade'] . "#" . $Info['lj_bairro'];
                endforeach;

                $arrDadosRegionais['qtdLj'] = count($arrDadosRegionais['lojas']);
                $arrDadosRegionais['regional'] = $Reg['nReg'];

                /* Busca dos estados envolvidos na regional */
                $Tbl = array('tb_lojas');
                $FullQuery2 = "SELECT DISTINCT lj_uf, b_cod FROM tb_lojas WHERE r_cod = {$Reg['nReg']}";
                $this->Crud->calldb($Tbl, 'SELECT', $Reg, null, $FullQuery2);
                $UF = $this->Crud->Results;
                $arrDadosRegionais['estados'] = $UF['Dados'];
                /* Busca dos Responsáveis técnicos da Regional */
                require_once(APPPATH . 'third_party/Func.php');
                $Resp = [];
                foreach ($UF['Dados'] as $ES):
                    $Tec = CheckRespTec($ES['lj_uf'], $ES['b_cod']);
                    $Resp [] = "'{$Tec}'";
                endforeach;
                $Tbl = array('tb_resp_tec');
                $Termos = implode(',', $Resp);
                $FullQuery = "SELECT * FROM tb_resp_tec where resp_cod in ({$Termos});";
                $this->Crud->calldb($Tbl, 'SELECT', $Reg, null, $FullQuery);
                $RespTec = $this->Crud->Results;
                $arrDadosRegionais['respTecnicos'] = $RespTec['Dados'];
            else:
                $arrDadosRegionais = false;
            endif;
            echo json_encode($arrDadosRegionais);
        endif;
    }

    /* Atualizar Dados do Gerente Regional */

    public function atualizaGRegional() {
        $GerReg = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($GerReg) and ! empty($GerReg['GerReg'])):
            $this->load->Model('Crud');
            $Where = array('gr_cod' => $GerReg['GerReg']['gr_cod']);
            unset($GerReg['GerReg']['gr_cod']);
            $this->Crud->calldb('tb_ger_reg', 'UPDATE', $GerReg['GerReg'], $Where);
            $Res = $this->Crud->Results;
            if ($Res):
                echo 'true';
            else:
                echo 'false';
            endif;
        endif;
    }

    /* Atualizar dados do Diretor da Regional */

    public function atualizaDRegional() {
        $DirReg = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($DirReg) and ! empty($DirReg['DirReg'])):
            $this->load->Model('Crud');
            $Where = array('dr_cod' => $DirReg['DirReg']['dr_cod']);
            unset($DirReg['DirReg']['dr_cod']);
            $this->Crud->calldb('tb_dir_reg', 'UPDATE', $DirReg['DirReg'], $Where);
            $Res = $this->Crud->Results;
            if ($Res):
                echo 'true';
            else:
                echo 'false';
            endif;
        endif;
    }

    /* Atualizar Cadastro do Resp. pelos ténicos */

    public function atualizatec() {
        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Dados) and ! empty($Dados['tecDados'])):
            $this->load->Model('Crud');

            if (!empty($Dados['tecDados']['insert'])):
                unset($Dados['tecDados']['insert']);
                $this->Crud->calldb('tb_resp_tec', 'SELECT');
                $Rows = $this->Crud->Results['lines'] + 1;
                $Dados['tecDados']['resp_rel'] = 'RT' . $Rows;
                $Dados['tecDados']['resp_cod'] = $Rows;
                $this->Crud->calldb('tb_resp_tec', 'INSERT', $Dados['tecDados']);
                $Res = $this->Crud->Results;
            else:
                $where = array('resp_cod' => $Dados['tecDados']['resp_cod']);
                unset($Dados['tecDados']['resp_cod']);
                $this->Crud->calldb('tb_resp_tec', 'UPDATE', $Dados['tecDados'], $where);
                $Res = $this->Crud->Results;
            endif;

            if ($Res == true):
                echo 'true';
            else:
                echo 'false';
            endif;
        endif;
    }

    /* Cadastrar uma Regional */

    public function cadRegional() {
        $NewReg = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($NewReg) and ! empty($NewReg['r_num'])):
            $this->load->Model('Crud');
            if (empty($_SESSION)):
                session_start();
            endif;
            /* Validação de existencia dos dados informados */

            /* Salvando dados da Regional */
            if (empty($_SESSION['Reg'])):
                $where = array('r_num' => $NewReg['r_num']);
                $this->Crud->calldb('tb_regional', 'SELECT', $where);
                $QTD = $this->Crud->Results['lines'];
                if ($QTD >= 1):
                    die("ERR01");
                else:
                    $Reg = array('r_num' => $NewReg['r_num'], 'r_name' => $NewReg['r_name']);
                    $this->Crud->calldb('tb_regional', 'INSERT', $Reg);
                    if ($this->Crud->Results == false):
                        die("ERR02");
                    endif;
                    $_SESSION['Reg'] = true;
                endif;
            endif;

            /* Salvando dados do Gerente Regional */
            if (empty($_SESSION['Gr']) and $_SESSION['Reg'] == true):
                $GReg = array('gr_email' => $NewReg['Greg']['gr_email']);
                $this->Crud->calldb('tb_ger_reg', 'SELECT', $GReg);
                if ($this->Crud->Results['lines'] >= 1):
                    die("ERR03");
                else:
                    $this->Crud->calldb('tb_ger_reg', 'SELECT');
                    $R = $this->Crud->Results['lines'] + 1;
                    $NewReg['Greg']['gr_rel'] = "GR" . $R;

                    $this->Crud->calldb('tb_ger_reg', 'INSERT', $NewReg['Greg']);
                    if ($this->Crud->Results == false):
                        die("ERR04");
                    endif;
                    $_SESSION['Gr'] = true;
                endif;
            endif;

            /* Salvando dados do Diretor Regional */
            if (empty($_SESSION['Dr']) and $_SESSION['Gr'] == true):
                $DReg = array('dr_email' => $NewReg['Dreg']['dr_email']);
                $this->Crud->calldb('tb_dir_reg', 'SELECT', $DReg);
                if ($this->Crud->Results['lines'] >= 1):
                    die("ERR05");
                else:
                    $this->Crud->calldb('tb_dir_reg', 'SELECT');
                    $D = $this->Crud->Results['lines'] + 1;
                    $NewReg['Dreg']['dr_rel'] = 'DR' . $D;
                    $NewReg['Dreg']['dr_reg_name'] = $NewReg['r_name'];
                    $this->Crud->calldb('tb_dir_reg', 'INSERT', $NewReg['Dreg']);
                    if ($this->Crud->Results == false):
                        die("ERR06");
                    endif;
                    $_SESSION['Dr'] = true;
                endif;
            endif;

            /* Atualizando as lojas na nova regional */
            if (empty($_SESSION['LjReg']) and $_SESSION['Dr'] == true):
                $Lojas = array_filter(explode(',', $NewReg['LojasReg']));
                foreach ($Lojas as $Lj):
                    $L[] = "'{$Lj}'";
                endforeach;
                $L = implode(',', $L);
                $Tabela = array('tb_lojas');
                $FullQuery = "UPDATE tb_lojas SET r_cod = {$NewReg['r_num']} WHERE lj_num in ({$L})";
                $this->Crud->calldb($Tabela, 'UPDATE', null, null, $FullQuery);
                if ($this->Crud->Results == true):
                    $_SESSION['LjReg'] = true;
                else:
                    die("ERR07");
                endif;
            endif;

            /* Adicionando relacionamentos */
            if (empty($_SESSION['RelReg']) and $_SESSION['LjReg'] == true):
                $Arr = [
                    'gr' => array('rel_user' => $NewReg['Greg']['gr_rel'], 'rel_reg' => $NewReg['r_num']),
                    'dr' => array('rel_user' => $NewReg['Dreg']['dr_rel'], 'rel_reg' => $NewReg['r_num'])
                ];

                foreach ($Arr as $RelRegLj):
                    $this->Crud->calldb('tb_rel_reg', 'INSERT', $RelRegLj);
                    $Res [] = $this->Crud->Results;
                endforeach;

                if ($Res[0] == true and $Res[1] == true):
                    echo "done";
                else:
                    die("ERR08");
                endif;
            endif;

            session_destroy();
        else:
            echo 'false';
        endif;
    }

    /* Gravando notas no chamado aberto */
    
    public function Savenotas(){
        
        $Notas = filter_input_array(INPUT_POST, FILTER_DEFAULT);       
        if(!empty($Notas) and !empty($Notas['ch_user'])):
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_ch_notas', 'INSERT', $Notas);           
            echo $this->Crud->Results;
        endif;
        
        
    }
    
}
