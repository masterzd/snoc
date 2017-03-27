<?php
/**
 * Description of EnviaSMS
 * Classe Responsável para fazer envio de SMS
 * @author henrique.souza
 */
class EnviaSMS {
    
    private $Status;
    private $Numeros;
    private $Mensagem;
    private $Result;
    private $Chamado;
    private $Loja;
    private $Band;
    public  $Falha;
    
    
    function __construct( array $Numeros, $Mensagem, $Status, $Loja = NULL, $Chamado = NULL) {
        $this->Numeros = $this->setNumeros($Numeros);
        $this->Mensagem = $this->setMensagem($Mensagem);
        $this->Status = $this->setStatus($Status);
        $this->Chamado = $this->setChamado($Chamado);
        $this->Loja = $this->setLoja($Loja);
        if($this->Status == "S"):
           $this->sendMensage();
        else:
            return TRUE;
        endif;
    }
            
    function setNumeros($Numeros) {       
        if(is_array($Numeros)):
            return $Numeros;
        else:
            die("Erro Ao Processar os dados!!");
        endif;
    }

    function setMensagem($Mensagem) {
        return $Mensagem;
    }
    
    function setChamado($Chamado){
        if(is_int($Chamado)):
            return $Chamado;
        endif;
    }


    function setLoja($Loja){
        if(is_array($Loja)):
            return $Loja;
        endif;    
    }

    /* Métodos Privados  */
    
    private function setStatus($Status) {        
        if($Status == 'S' or $Status == 'N'):
            return $Status;
        else:
            die("Erro Ao Processar os dados!!");
        endif;        
    }


    private function sendMensage() {  
        
        $this->Mensagem = str_replace(' ', '%20', $this->Mensagem); 

        $Grv = new Insert;

        
        foreach ($this->Numeros as $Num):
        $cURL = curl_init("https://www.mpgateway.com/v_3_00/sms/smspush/enviasms.aspx?Credencial=860F7D1569FD5C445706A84D0358F5612E3EF235&Token=3F902a&Principal_User=SISNOCRE&Aux_User=SISNOCRE&Mobile=55$Num&Send_Project=N&Message=$this->Mensagem");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        $resultado = curl_exec($cURL);
        $resposta = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
 
       
        $Arr = [
            'sms_sit_env' => $resultado,
            'sms_num' => $Num,
            'sms_date' => date('Y-m-d H:i:s'),
            'sms_loja' => $this->Loja[0],
            'sms_ch' => $this->Chamado
        ];

        $Grv->ExeInsert('tb_sms', $Arr);


        if($resultado != '000'):
            $this->Result [] = FALSE;
        else:
            $this->Result []= TRUE;
        endif;

        endforeach; 

        
        if(in_array(FALSE, $this->Result)):
            $this->Falha = TRUE;
        else:
            $this->Falha = FALSE;
        endif;
              
    }
 
}
