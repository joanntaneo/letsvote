<?php

require_once '../controller/DatabaseManager.php';

/**
 * Description of Position : Object that handles the position details including the
 * Position Description
 * Position Allowed Votes
 *
 * @author joann
 */
class Position {
    private $code;
    private $name;
    private $allowedVotes;
    
    public function __construct()    
    {    
        $this->code = '';
        $this->name = '';
        $this->allowedVotes = 0;
    }  
    
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    
    public function insert(){
        $sql = "INSERT INTO positions (positionCode, positionName, allowedVotes)"
               . " VALUES ('".$this->code."', '".$this->name."', ".$this->allowedVotes.")";
        DatabaseManager::executeSql($sql);
    }
    
    public function get($conn, $posid){
        $sql = "SELECT * FROM positions WHERE positionCode = '".$posid."'";
        return DatabaseManager::executeSql($sql);
    }
    
}
