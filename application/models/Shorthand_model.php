<?php

class Shorthand_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


/* Funções de Gestão de Usuário */
	public function getUsers($User){

		$this->db->select('*');
		$this->db->from('tb_usuarios');
		$this->db->like('u_user', $User);
		$query = $this->db->get();
		$Count = $query->num_rows();

		if($Count >= 1):
			$DadosBD = $query->result_array();
		else:
			$DadosBD = FALSE;
		endif;	
		return $DadosBD;
	}

	public function delUsers($id){		
		$this->db->delete('tb_usuarios', array('u_user' => $id));
		$Count = $this->db->affected_rows();
		return $Count;
	}



	public function insereUser($dados){

		if(!is_array($dados)):
			echo "Falha nos dados";
		else:
			unset($dados['u_senha2']);
			$this->db->insert('tb_usuarios', $dados);
			$rowaffect = $this->db->affected_rows();
			if($rowaffect == 1):
				echo "success";
			elseif($rowaffect < 1):
				echo "falha-01";
			elseif($rowaffect > 1):		
				echo "falha-02";	
			endif;	
		endif;	

	}

	public function updateUser($dados){
		$this->db->where('u_cod', $dados['u_cod']);
		unset($dados['u_cod']);
		$this->db->update('tb_usuarios', $dados);
		$rowaffect = $this->db->affected_rows();
		return $rowaffect;
	}

/* Funções de Gestão de Usuário - Fim */



/* Funções de Gestão de Loja */


	public function getLoja($termo){
		
		$this->db->select('*');
		$this->db->from('tb_lojas');
		$this->db->like('lj_num', $termo, 'before');
		$query = $this->db->get();
		$Count = $query->num_rows();
		if($Count >= 1):
			$DadosArr = $query->result_array();
		else:
			$DadosArr = FALSE;
		endif;	
		return $DadosArr;

	}

	public function delLoja($id){
		$this->db->delete('tb_lojas', array('lj_cod' => $id));
		$Count = $this->db->affected_rows();
		return $Count;
	}

	public function cadastraLink($Link){
		$this->db->insert('tb_circuitos', $Link);
		$rowaffect = $this->db->affected_rows();
		return $rowaffect;
	}

	public function InsertLoja($DadosLoja){
		$this->db->insert('tb_lojas', $DadosLoja['loja']);
		$rowaffect = $this->db->affected_rows();
		return $rowaffect;
	}

	public function verLink($Loja){
		$this->db->select('*');
		$this->db->from('tb_circuitos');
		$this->db->like('cir_loja', $Loja);
		$query = $this->db->get();
		$Count = $query->num_rows();
		return $Count;
	}



	public function getRegionais(){		
		$query = $this->db->get('tb_regional');
		$Count = $query->num_rows();
		if($Count >= 1):
			$Ret = $query->result_array();

			foreach($Ret as $Rg):
				$Retorno [] = $Rg['r_num'];
			endforeach;	
		else:
			$Retorno = null;
		endif;	

		return $Retorno;

	}



	/* Funções de Gestão de Loja - Fim */
}