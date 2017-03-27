<?php

class GravaAcaoTipo extends Conn {
    
    private $Tabela;
    private $Query;
    private $Dados;
    private $NumCh;
            
    function __construct($Tabela, $Dados, $NumCh) {
        $this->Tabela = $this->setTabela($Tabela);
        $this->Dados = $this->setDados($Dados);
        $this->NumCh = $this->setNumCh($NumCh);
        $this->Insere();       
    }
    
   
    
    function setTabela($Tabela) {
        if($Tabela == 'tb_ch_prob' or $Tabela == 'tb_ch_acao'):
            return $Tabela;
        else:
            die('Dados Inválidos');
        endif;        
    }
   
    function setDados($Dados) {
        if(is_array($Dados)):
            return $Dados;
        else:
            die('Dados Inválidos');
        endif;
        
    }
    
    public function setNumCh($NumCh) {
        if(is_int($NumCh)):
            return $NumCh;
        endif;
    } 
    
    function Insere() {
        $Conn = new Conn;
        $this->Query = "INSERT INTO {$this->Tabela} VALUES (:vl1, :vl2)";
        $exe = $Conn->getConectar()->prepare($this->Query);
        
         foreach ($this->Dados as $info):
                    try {
                        $exe->bindValue(':vl1', $this->NumCh, PDO::PARAM_INT);
                        $exe->bindValue(':vl2', $info, PDO::PARAM_STR);
                        $exe->execute();
                    } catch (PDOException $e) {
                        echo $erro = $e->getMessage();
                        die;
                    }
        endforeach;
    }
    
}
