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
            $Validation['erro'] = "Sessão Expirada. Fazer login novamente.";
            $this->load->view('login', $Validation);
        else:
            $this->menu();
        endif;
    }

    /* Funções */

    public function menu() {
        
        $this->load->Model('Crud');
        $TB = array('tb');
        $Da = array('ok');
        $QR = "SELECT * FROM tb_eventos  ORDER BY e_cod DESC LIMIT 4";
        $this->Crud->calldb($TB, 'SELECT', $Da, 0, $QR);        
        $this->load->view('menuprincipal', $this->Crud->Results);
    }

    public function cadlink() {
        $this->load->view('cad-link');
    }

    public function chamado() {
        $this->load->view('nova-ocorrencia');
    }

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

}
