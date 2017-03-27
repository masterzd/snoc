<?php

/**
 * <b>Classe de Consulta de dados no Banco</b>
 * 
 * Classe que Vai se responsabilizar pela consulta de dados no Banco de Dados
 */
class Consulta extends Conn {
    
    /**
     * @var type String - Select: Armazena parte ou a Query completa para a consulta no banco
     * @var Type String - Places: Armazena os parametros para ser usado na query Dinânica
     * @var objeto Description: Atributo onde vai armazenar o Resultado da Consulta feita no Banco. 
     */
    private $Select;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Read;

    /** @var PDO: Atributo que carrega a Herança da Classe Pai Conn, onde possui os metodos necessários para conectar-se ao
     * Banco  de dados.*/
    private $Conn;

    
    /* 
     * Metodo Responsável por Montar a Query Dinânica. Os parametros usados aqui são o nome da Tabela a ser consultada, 
     * as consdições de Pesquisa usando Prepare Statemants(se houver) e os dados que serão ultilzados na query preparada usando
     * o bindValue. Faz a conversão dos dos dados no parametro $StringParcial em array. Monta a Query e coloca no Atributo Select e 
     * chama o Metodo executar.   
     */
    public function ExeLer($Tabela, $Termos = NULL, $StringParcial = NULL) {
        if (!empty($StringParcial)):
            parse_str($StringParcial, $this->Places);
        endif;
        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->Executar();
        
    }
    
    /*
     * Metodo Responsável por retornar os resultados da ultima consulta feita
     */
    public function pegarResultados() {
        return $this->Result;
    }
    
    /*
     * Metodo Responsável por Contar os resultados da ultima consulta feita
     */
    public function ContarLinhas() {
        return $this->Read->rowCount();
    }
    
    /*
     * Metodo Responsável por Gerar uma query completa para fazer a consulta no banco
     * Informa a query completa no parametro query e os dados para ser usados no Prepare Statemants
     * Faz a conversão dos dos dados no parametro $StringParcial em array  e Depois chama o metodo executar
     */
    public function QueryCompleta($Query, $StringParcial = NULL) {

        $this->Select = (string) $Query;
        if (!empty($StringParcial)):
            parse_str($StringParcial, $this->Places);
        endif;
        
        $this->Executar();
    }
    
    /*
     * Metodo Responsável por mudar os parametros usados na consulta reaproveitando a mesma query
     */
    
    public function MudarParametros($StringParcial) {
        parse_str($StringParcial, $this->Places);
        $this->Executar();
    }

    /**
     *  ****************************************
     *  ********** Metodos Privados ************
     *  ****************************************
     */
    
    /* 
     * Metodo Responsável por Fazer a Conexão com o Banco de dados, usando os metodos herdados da Classe Conn
     */
    private function Conectar() {
        $this->Conn = parent::getConectar();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }
    
    
    /* 
     * Metodo Responsável por Montar a Query com a sintaxe correta e Fazer o blindValue
     */
    private function gerarSintaxe() {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if ($Vinculo == 'limit' or $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;

                $this->Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
                
            endforeach;
        endif;
    }

    private function Executar() {
        
        $this->Conectar();
        try {
            $this->gerarSintaxe();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = NULL;
            echo $erro = $e->getMessage();
            die;
        }
    }

}
