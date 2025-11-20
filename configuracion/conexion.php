<?php

//Definir clase
class Database{
    //Definir atributos
    private static $host = "localhost";
    private static $user_name = "root";
    private static $db_name = "don_camaron";
    private static $password = "";
    private static $charset = "utf8mb4";
    private static $pdo = null;

    //Definir constructor
    private function __construct(){}

    public static function connect(){
        if(self::$pdo === null){
            try{
                 $dn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=" . self::$charset;

                self::$pdo = new PDO($dn, self::$user_name, self::$password);

                self::$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                die("Error de conexion: " .$e -> getMessage());
            }
        }
        return self::$pdo;
    }
}

?>