<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    /* Funções que Carregam as Views do Sistema */

    public function index() {
        if (empty($_POST['u_user']) and empty($_SESSION['user'])):
            $this->load->view('login');
        else:
            $this->menu();
        endif;
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

    /* Funções */

    public function menu() {

        $this->load->Model('Crud');
        $QR = "SELECT * FROM tb_eventos  ORDER BY e_cod DESC LIMIT 4";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $Info['eventos'] = $this->Crud->Results['Dados'];

        $QR2 = "SELECT o_cod FROM tb_ocorrencias WHERE o_sit_ch NOT LIKE 1 AND o_sit_ch NOT LIKE 8";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
        $Info['abChamados'] = $this->Crud->Results['lines'];

        $this->load->view('menuprincipal', $Info);
    }

    public function cadlink() {
        $this->load->view('cad-link');
    }

    public function chamado() {
        $this->load->view('nova-ocorrencia');
    }

    public function sair() {
        session_destroy();
        header('Location:' . base_url('Start'));
        return false;
    }

    public function checklink() {

        if (!empty($this->input->get('loja'))):
            $Loja = array('cir_loja' => $this->input->get('loja'));
            $this->load->Model('Crud');
            $this->Crud->calldb('tb_circuitos', 'SELECT', $Loja);
            $Result = $this->Crud->Results;
            if(!empty($Result['Dados'])):
            else:
               $Result['Dados'][0]['cir_loja'] =  $this->input->get('loja');
            endif;
            
            $this->load->view('checkLink', $Result);
        else:
            die("Erro Localizar os dados!!");
        endif;
    }

    /* Função para fazer a validação do usuário de senha */

    public function validacao() {

        /* Validação de formulário */
        $this->form_validation->set_rules('u_user', 'Nome de Usuário', 'trim|required|min_length[6]', array('required' => 'Informe o nome de usuário.'));
        $this->form_validation->set_rules('u_senha', 'Senha', 'trim|required|min_length[8]', array('required' => 'Informe a senha.'));

        if (!empty($_POST)):
            if ($this->form_validation->run() == FALSE):
                $Validation['erro'] = validation_errors();
                $this->load->view('login', $Validation);
            else:

                $DadosLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                $DadosLogin['u_senha'] = sha1($DadosLogin['u_senha']);
                $this->load->Model('Crud');
                $this->Crud->calldb('tb_usuarios', 'SELECT', $DadosLogin);
                if ($this->Crud->Results['lines'] == 1):
                    session_start();
                    $_SESSION['user'] = [
                        'Nome' => $this->Crud->Results['Dados'][0]['u_nome'],
                        'Nv' => $this->Crud->Results['Dados'][0]['u_nivel_acesso'],
                        'Img' => $this->Crud->Results['Dados'][0]['u_img'],
                        'Funcao' => $this->Crud->Results['Dados'][0]['u_funcao'],
                        'data' => date("Y-m-d H:i:s")
                    ];

                    $this->Crud->calldb('tb_conf', 'SELECT', 0);
                    unset($_POST['u_user'], $_POST['u_senha']);
                    header("Location:" . base_url('menuprincipal'));
                else:
                    $Validation['erro'] = "Usuário ou Senha Inválidos!";
                    $this->load->view('login', $Validation);
                endif;

            endif;
        else:
            $Validation = NULL;
            $this->load->view('login', $Validation);
        endif;
    }

    public function verLink($Loja) {
        $this->load->Model('Shorthand_model');
        $Get = $this->Shorthand_model->verLink($Loja);

        if ($Get >= 1):
            echo "ok";
        else:
            echo "no";
        endif;
    }

    public function manager() {
        $this->load->Model('Shorthand_model');
        $Regional = $this->Shorthand_model->getRegionais();
        if (is_array($Regional)):
            $ViewReg['regional'] = $Regional;
            $this->load->view('manager', $ViewReg);
        else:
            die("Falha ao Carregar os dados - ARR_REG");
        endif;
    }

    public function consultaFilial() {
        $LJ = (int) $this->input->get('Lj');
        if ($LJ == NULL):
            die('Parametro inválido');
        endif;
        $this->load->library('infolojas');
        $this->load->Model('Crud');
        $this->infolojas->CheckDadosLoja($LJ, 0, false);
        $QR = "SELECT o_cod, o_link, o_prazo, o_opr_ab, o_nece, o_sit_ch FROM tb_ocorrencias WHERE o_loja = {$LJ} ORDER BY o_cod DESC LIMIT 5";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR);
        $LojasInfo = $this->infolojas->DadosLoja;
        $LojasInfo['Resp'] = $this->infolojas->ContatosSms;
        $LojasInfo['Ocorrencias'] = $this->Crud->Results['Dados'];

        if (!empty($LojasInfo['mensagem'])):
            if (empty($_SESSION)):
                session_start();
            endif;
            $Erro['Title'] = "OPS!! Alguma coisa ocorreu fora do esperado";
            $Erro['Msg'] = "O Cadastro dessa loja não está completo. Verifique os dados e tente novamente";
            $this->load->view('errors/Erro', $Erro);
        else:    
            $this->load->view('filiais', $LojasInfo);
        endif;

    }

    public function chToday() {
        $this->load->Model('Crud');
        $QR1 = "SELECT * FROM tb_ocorrencias WHERE o_hr_ch BETWEEN '" . date('Y-m-d') . " 00:00:00' AND '" . date('Y-m-d') . " 23:59:59'";
        $QR2 = "SELECT * FROM tb_ocorrencias WHERE o_hr_fc BETWEEN '" . date('Y-m-d') . " 00:00:00' AND '" . date('Y-m-d') . " 23:59:59'";
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR1);
        $DadosToday['abHoje'] = $this->Crud->Results['Dados'];
        $this->Crud->calldb(0, 'SELECT', 0, 0, $QR2);
        $DadosToday['fcHoje'] = $this->Crud->Results['Dados'];
        $this->load->view('chamadoDia', $DadosToday);
    }

    public function relatorios() {
        $this->load->view('relatorios');
    }

}
