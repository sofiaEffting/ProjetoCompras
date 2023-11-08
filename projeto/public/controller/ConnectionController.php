<?php

namespace Database;

//nao vai poder ser instanciada
abstract class ConnectionController{

    public static $conexao;
    public static function connectDb()
    {
        try{
        
            if(!self::$conexao){

                self::$conexao = new \PDO("mysql:host=dev_ifc.db4free.net;dbname=compras_ifc", 'dev_ifc', 'q1w2e3r4t5');
            }
            return self::$conexao;
        
        }catch(\PDOException $e){
    
            echo 'Não foi possível se conectar ao Banco de dados. Verifique sua conexão com a internet e tente novamente mais tarde. <br>';
            echo 'ERROR: ' . $e->getMessage();
    
        }
    }
}