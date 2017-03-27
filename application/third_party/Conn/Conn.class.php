<?php

class Conn {

    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $DB = DB;

    
    /** @param PDO */
    private static $Connect = null;

    private function Conectar() {
            try {
                
                if (self::$Connect == NULL):                    
                $dsn = "mysql:host=" . self::$Host . ";dbname=" . self::$DB;
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
                endif;
                
                
            } catch (PDOException $e) {
                echo $erro = $e->getMessage();
                die;
            }
                        
           self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           return self::$Connect;
    }

    public function getConectar() {
        return self::Conectar();
    }

}
