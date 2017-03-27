<?php

//DEFINIÇÃO DAS CONTANTES DO BANCO DE DADOS

define('HOST','localhost');
//define('USER','root');
//define('PASS','tnt789');
define('USER','sisnoc');
define('PASS','Sisjml');
define('DB','sisnoc');

//Função Para incluir automaticamente as classes. 
function __autoload($Classe){
    
    $pasta = ['Conn'];
    $inPasta = FALSE;
    
    foreach ($pasta as $NomePasta):
           
        if(!$inPasta && file_exists(__DIR__.DIRECTORY_SEPARATOR.$NomePasta.DIRECTORY_SEPARATOR.$Classe.".class.php") && !is_dir(__DIR__.DIRECTORY_SEPARATOR.$NomePasta.DIRECTORY_SEPARATOR.$Classe.".class.php")):
            include_once (__DIR__.DIRECTORY_SEPARATOR.$NomePasta.DIRECTORY_SEPARATOR.$Classe.".class.php");
            $inPasta = true;
        endif;        
    endforeach;
    
  if(!$inPasta):
      trigger_error("Não foi possível incluir {$Classe}.class.php", E_USER_ERROR);
  endif;  

  
    
}
