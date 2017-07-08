<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SSH extends CI_Controller {

    private $User;
    private $Pass;
    private $Port;
    private $IP;
    private $CI;
    private $Conn;
    public $Status;
    public $Auth;

    public function __construct() {
        $this->CI = & get_instance();
    }

    function setIP($IP) {
        $this->IP = $IP;
    }

    function setUser($User) {
        $this->User = $User;
    }

    function setPass($Pass) {
        $this->Pass = $Pass;
    }

    function setPort($Port) {
        $this->Port = $Port;
    }

    public function Connection($User, $Pass, $Port, $IP) {
        $this->setUser($User);
        $this->setPass($Pass);
        $this->setPort($Port);
        $this->setIP($IP);


        if (!function_exists("ssh2_connect")):
            return "O SSH não está Habilitado no Servidor.";
        else:
            $this->Conn = ssh2_connect($this->IP, $this->Port);
            $Login = ssh2_auth_password($this->Conn, $this->User, $this->Pass);
        endif;

        if (!empty($this->Conn)):
            $this->Status = "Conectado";
        else:
            $this->Status = "Desconectado";
        endif;

        if ($Login):
            $this->Auth = TRUE;
        else:
            $this->Auth = FALSE;
        endif;
    }

    public function exeCommand($Command) {
        $Exe = ssh2_exec($this->Conn, $Command);
        stream_set_blocking($Exe, true);
        $Retorno = "";
        while ($Buff = fread($Exe, 4096)):
            $Retorno .= $Buff;
        endwhile;
        $Retorno = explode("\r\n", $Retorno);

        return $Retorno;
    }

}
