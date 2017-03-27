<?php

/*
 * <b>Atualizar.class</b>
 * 
 * Classe responsável por fazer atualizações nos dados do Banco. 
 *  
 */

class Atualizar extends Conn {
    
    /*
     * @var Tabela: Atributo onde fica armazenado o nome da Tabela a ser consultada.
     * @var Dados: Atributo onde fica armazenado os campos e os Valores da Tabela que receberão a atualização.
     * @var Termos: Atributo onde fica armazenado as condições para a atualização de dados ser feita.
     * @var Lugar: Atributo onde vai receber os parametros para executar o update.
     * @var Resultado: Atributo que recebe valor booleano. Se o update for feito retorna true e se não acontecer retorna false.
     * 
     */
    private $Tabela;
    private $Dados;
    private $Termos;
    private $Lugar;
    private $Resultado;
    
    /*@var PDOStatement*/
    private $Update;
    
    /** @var PDO  Atributo que recebe os metodos e atributos da classe PDO*/    
    private $Conn;
    
    /*
     * Metodo que recebe os dados que serão usados na query. A variável tabela recebe o nome da tabela do banco que ira ser atualizada. O Array Dados recebe
     * os nomes dos campos do banco que serão atualizados, A variável Termos contém a condição para o update ser feito e o ParseString contém os parametros
     * para serem usados na condição da query.       
     */
    public function ExeAtualizacao($Tabela, array $Dados, $Termos, $ParseString) {        
        
        /* Verifica se o array dados está com a senha informada pelo usuário. Se houver será feita a criptografia da senha antes de ser gravada no banco*/        
        if(array_key_exists('u_senha', $Dados)):
           $Dados['u_senha'] = sha1($Dados['u_senha']);
        endif;
        
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;    
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Lugar);
        $this->montarSintaxe();
        $this->Executar();
        
    }
    
    /* Metodo de retorna um array com os resultados do update feito. */
    public function pegarResultados() {
        return $this->Resultado;
    }
    
    /* Metodo que conta o total de linhas afetadas pelo update feito no banco */
    public function contarLinhas() {
        return $this->Update->rowCount();
    }
    
    /* metodo que reexecuta a query com os parametros informados na condição diferente */
    public function confcondicao($ParseString) {        
        parse_str($ParseString, $this->Lugar);
        $this->montarSintaxe();
        $this->Executar;        
    }
    
    
    /*
     ******************************************
     ************* Metodos Privados ***********
     ******************************************
     */
    
    
    /* Metodo privado que Faz a conexão com o banco de dados e Faz a preparação da query para ser executada no Metodo executar*/
    private function Conectar() {     
        $this->Conn = parent::getConectar();
        $this->Update = $this->Conn->prepare($this->Update);
    }
    
    /* metodo Privado que monta a sintaxe da query para ser preparada e depois ser executada no Método executar */
    private function montarSintaxe() {       
        foreach ($this->Dados as $Key => $Valor):            
            $Places[] = $Key .' = :' . $Key;   
        endforeach;
        $Places = implode(', ', $Places);
        $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }
    /* metodo Privado que faz a execução da query preparada e retorna true ou false no atributo Resultado. */
    private function Executar() {
        $this->Conectar();
        try {
            
//            var_dump($this->Update, $this->Dados, $this->Lugar, $this->Dados);
            
            $this->Update->execute(array_merge($this->Dados, $this->Lugar));
            $this->Resultado = true;
            
        } catch (PDOException $e) {
            $this->Result = NULL;
            echo $erro = $e->getMessage();
            die;
        }
        
        
    }
    
    
    
}
