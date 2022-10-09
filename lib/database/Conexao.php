<?php

class Conexao{

    private static $con;
    private static $username = "root";
    private static $password = "";

    private function __construct(){}

    // Realiza a conexão com o banco de dados usando o padrão singleton
    public static function getConnection(){
        if(!isset(self::$con)){

            try{
                self::$con = new PDO('mysql:host=localhost;dbname=bd_blog', self::$username, self::$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Erro ao conectar a base de dados";
            }
            
        }
        return self::$con;
    }

}