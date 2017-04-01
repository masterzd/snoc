<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

    private $Tabela;
    private $Dados;
    private $Helper;
    private $FullQuery;
    public $LastInsertID;
    public $Results;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function calldb($Tabela, $Opc, $Dados = null, $Helper = null, $FullQuery = null) {
        $this->setTabela($Tabela);
        $this->setDados($Dados);
        $this->setHelper($Helper);
        $this->setFullQuery($FullQuery);

        if ($Opc == 'SELECT'):
            $Exe = $this->search();
        elseif ($Opc == 'INSERT'):
            $Exe = $this->insere();
        elseif ($Opc == 'DELETE'):
            $Exe = $this->deletar();
        elseif ($Opc == 'UPDATE'):
            $Exe = $this->atualizar();
        endif;
    }

    public function setTabela($Tabela) {
        $this->Tabela = $Tabela;
    }

    public function setDados($Dados) {
        $this->Dados = $Dados;
    }

    public function setHelper($Helper) {
        $this->Helper = $Helper;
    }

    public function setFullQuery($FullQuery) {
        $this->FullQuery = $FullQuery;
    }

    /** Metodos Privados * */
    private function search() {

        if (is_array($this->Dados) and is_array($this->Tabela)):
            $query = $this->db->query($this->FullQuery);
        elseif (is_array($this->Dados)):
            $query = $this->db->get_where($this->Tabela, $this->Dados);
        else:
            $query = $this->db->get($this->Tabela);
        endif;

        $Lines = $query->num_rows();
        if ($Lines >= 1):
            $this->Results = array();
            $this->Results['lines'] = $Lines;
            $this->Results['Dados'] = $query->result_array();
        else:
            $this->Results = false;
        endif;
    }

    private function insere() {

        if (is_array($this->Dados)):

            $this->db->insert($this->Tabela, $this->Dados);
            $rowaffect = $this->db->affected_rows();
            $this->LastInsertID = $this->db->insert_id();

            if ($rowaffect >= 1):
                $this->Results = true;
            else:
                $this->Results = false;
            endif;

        else:
            $this->Results = false;
        endif;
    }

    private function deletar() {

        $this->db->delete($this->Tabela, $this->Dados);
        $rowaffect = $this->db->affected_rows();

        if ($rowaffect >= 1):
            $this->Results['result'] = true;
            $this->Results['rows'] = $rowaffect;
        else:
            $this->Results = false;
        endif;
    }

    private function atualizar() {

        if (is_array($this->Tabela)):
            $query = $this->db->query($this->FullQuery);
        else:
            $this->db->update($this->Tabela, $this->Dados, $this->Helper);
        endif;

        $rowaffect = $this->db->affected_rows();
        if ($rowaffect >= 1):
            $this->Results = true;
        else:
            $this->Results = false;
        endif;
    }

}
