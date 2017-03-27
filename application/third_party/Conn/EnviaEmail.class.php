<?php

/**
 * Classe Responsável para enviar email
 * @author henrique.souza
 */
class EnviaEmail {

    private $Mensagem;
    private $Destinatarios;
    private $Cabecalhos;
    private $Assunto;
    private $Status;
    private $Ch;
    public $Result;

    function __construct($Mensagem, array $Destinatarios, $Assunto, $Status, $Ch = NULL) {
        $this->Mensagem = $Mensagem;
        $this->Destinatarios = $Destinatarios;
        $this->Assunto = $Assunto;
        $this->Status = $this->getStatus($Status); 


        if($this->Status == 'S'):
            $this->envia();
        else:
           $this->Result [] = true;                 
        endif;    
        
    }


    private function getStatus($Status){
        if($Status == 'S' or $Status == 'N'):
            return $Status;
        else:
            die("Erro Ao Definir Permissão de Envio");        
        endif;    
    }    



    private function envia() {

        $this->Cabecalhos = "Content-Type:text/html; charset=UTF-8\n";
        $this->Cabecalhos .= "From: SISNOC<sisnoc2016@ricardoeletro.com.br>\n";
        $this->Cabecalhos .= "X-Sender: <sisnoc2016@gmail.com>\n";
        $this->Cabecalhos .= "X-Mailer: PHP v" . phpversion() . "\n";
        $this->Cabecalhos .= "Return-Path: <sisnoc2016@ricardoeletro.com.br>\n";
        $this->Cabecalhos .= "MIME-Version: 1.0\n";

        foreach ($this->Destinatarios as $Env):

            $this->Result [] = mail($Env, $this->Assunto, $this->Mensagem, $this->Cabecalhos);

            $indice = 0;

            $date = date('d-m-Y H:i:s');
            $File = '/var/www/ocorrencias/_app/Helpers/logemail.txt';
            $create = fopen($File, 'a+');
            fwrite($create, "{$date} - {$Env} - {$this->Result[$indice]} - {$this->Ch}\n");
            fclose($create);

            ++ $indice;

        endforeach;


    }

}
