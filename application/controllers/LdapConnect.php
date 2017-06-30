<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Classe responsável por fazer a conexão via Active Directory  */
class LdapConnect extends CI_Controller {

    private $Server = "MV-L3-DC01.maquinadevendas.corp";
    private $Domain = "MAQUINADEVENDAS";

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function Connect() {
        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($Dados['u_user']) and ! empty($Dados['u_senha'])):
            $ldapConn = ldap_connect($this->Server);
            $Username = $this->Domain . "\\" . $Dados['u_user'];
            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
            $bind = @ldap_bind($ldapConn, $Username, $Dados['u_senha']);

            if ($bind):
                $filtro = "(sAMAccountName={$Dados['u_user']})";
                $result = ldap_search($ldapConn, "dc={$this->Domain},dc=CORP", $filtro);
                $info = ldap_get_entries($ldapConn, $result);

                $Permissao = false;

                foreach ($info[0]['memberof'] as $Per):
                    if (preg_match('/CN=NOC/', $Per)):
                        $Permissao = true;
                    endif;
                endforeach;

                if ($Permissao == true):                    
                    if(empty($_SESSION)):
                        session_start();
                    endif;

                    $_SESSION['user'] = [
                        'Nome' => $info[0]['cn'][0],
                        'Nv' => ($Permissao = true ? 1 : 2),
                        'Funcao' => $info[0]['department'][0],
                        'data' => date("Y-m-d H:i:s")
                    ];
                    header("Location:" . base_url('menuprincipal'));
                else:
                    $Validation['erro'] = "Você não tem permissão para acessar esse sistema";
                    $this->load->view('login', $Validation);
                endif;

            else:
                $Validation['erro'] = "Usuário ou Senha Inválidos!";
                $this->load->view('login', $Validation);
            endif;
        endif;
    }

}
