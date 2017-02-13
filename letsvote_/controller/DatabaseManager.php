<?php


/**
 * Description of DatabaseManager - handles Database transactions
 *
 * @author joann
 */
class DatabaseManager {
    private static $connection = NULL;
    
        public static function getConnection(){
        if (!isset(self::$connection)){ 
            self::$connection = new mysqli('localhost','root','','letsvotedb');
            if (mysqli_connect_errno()) {
                echo self::$connection->connect_error;
                die("Connection failed: " . self::$connection->connect_error);
            } 
        }
        return self::$connection;
    }   
    
    public static function executeSql($sql){     
        $result = self::getConnection()->query($sql);       
        return $result;
    }
}
