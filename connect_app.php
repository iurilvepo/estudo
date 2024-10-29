<?php

class Conexao{

private static $connect;

public static function getConexao(){

    if( !isset(self::$connect) ){
       // self::$connect = new \PDO("mysql:host=186.202.152.67;dbname=jadehotel","jadehotel","Vitlnx!@#2009");
        self::$connect = new \PDO("mysql:host=localhost;dbname=jadehotel","preco","vitlnx2009");
        return self::$connect;
    }else{
        return self::$connect;
    }
    
            

}


}

?>