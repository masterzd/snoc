<?php
/**
 * <b>Classe para fazer Insert no banco de dados</b>
 */

class Insert extends Conn {
    /**
     * @var STRING $Tabela = Atributo que armazena o nome da tabela que será feita o insert  
     * @var ARRAY $Dados = Atributo que vai armazenar um array com o nome das colunas
     * @var STRING $Result = Atributo que vai armazenar os resultados da consulta
     */
    private $Tabela;
    private $Dados;
    private $Result;
    
    /** @var PDOStatement  $Create = Atributo que vai receber a query montada dinâmicamente*/
    private $Create;
    
    /** @var PDO  $Conn = Atributo que vai receber o objeto da classe PDO*/
    private $Conn;
    
    /**
     * <b>ExeInsert</b>
     * Método responsável por fazer o Insert na tabela. Primeiro armazena no atributo Tabela o conteúdo da   variável $Tabela. Depois faz o mesmo com o atributo Dados.
     * Executa o metodo getSintax e depois o executar.
     * @param STRING $Tabela = Parametro que vai receber o nome da tabela que será usada no insert
     * @param ARRAY $Dados = Parametro do tipo array que vai receber os campos da tabela que serão modificados 
     */
    public function ExeInsert($Tabela, array $Dados) {
        if(array_key_exists('u_senha', $Dados)):
           $Dados['u_senha'] = sha1($Dados['u_senha']);
        endif;
        
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados; 
        $this->gerarSyntaxe();
        $this->Executar();
    }
    /**
     * @return STRING Retorna a consulta feita no banco
     */
    public function gerarResultados() {
        return $this->Result;
    }
    
    /*
     * ****************************************
     * ***********Metodos Privados**************
     * ****************************************
     */
    
    /** 
     *<b>Concetar</b>
     * Metodo para fazer a conexão com o banco de dados atraves da classe Conn. E faz o prepare com o conteúdo do atributo create 
     */
    private function Conectar() {
        $this->Conn = parent::getConectar();
        $this->Create = $this->Conn->prepare($this->Create);
    }
    
    /** 
     * <b>gerarSyntaxe</b>
     * Metodo para montar a sintaxe correta da query do banco. Primeiro faz o implode no array que está no atributo Dados separando por virgula e espaço e coloca na variável Fields.
     * Depois faz um implode novamente no atributo Dados separando por ", :" . Depois o atributo create recebe a query montada.  
     */
    private function gerarSyntaxe() {
        $Fields = implode(', ', array_keys($this->Dados));
        $Places =':'. implode(', :', array_keys($this->Dados));
        $this->Create = "INSERT INTO {$this->Tabela} ({$Fields}) VALUES ({$Places})";
    }
    
    
    /** <b>Executar</b>
     * 
     * Metodo responsável por fazer a execução da query. Primeiro ele vai chamar o metodo Conectar. Usando o try, ele vai usar o metodo PDO execute com os dados do atributo
     * dados, depois o atributo result recebe o numero do ultimo ID inserido.
     * 
     *  */
    private function Executar() {
         


        $this->Conectar();
        try {            
            $this->Create->execute($this->Dados);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = NULL;
           echo $erro = "Erro ao Inserir os dados: {$e->getMessage()} <br>Na linha: {$e->getLine()} <br>Arquivo: {$e->getFile()}<br>";
           die;
           
        }
        
    }
    
    
}
