<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ValidationLogin_model extends CI_Model{


	private $Tabela;
	private $Dados;
	public 	$Result;


	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function CallBd($Tabela, $Dados){
		$this->Tabela = $this->setTabela($Tabela);
		$this->Dados = $this->setDados($Dados);
		$this->Consulta();
	}

    /**
     * Sets the value of Tabela.
     *
     * @param mixed $Tabela the tabela
     *
     * @return self
     */
    public function setTabela($Tabela)
    {
       return $Tabela;
    }

    /**
     * Sets the value of Operacao.
     *
     * @param mixed $Operacao the operacao
     *
     * @return self
     */
  
    /**
     * Sets the value of Dados.
     *
     * @param mixed $Dados the dados
     *
     * @return self
     */
    public function setDados($Dados)
    {
    	if(is_array($Dados)):
    		return $Dados;
    	endif;	        
    }

    /**Metodos Privados**/

    private function Consulta(){  	
    	
      $query = $this->db->get_where($this->Tabela, array('u_user' => $this->Dados['u_user'], 'u_senha' => sha1($this->Dados['u_senha'])), 1);
      $this->Result = $query->num_rows();
      
    }



}