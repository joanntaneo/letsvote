<?php

require_once '../controller/DatabaseManager.php';

/**
 * Description of Candidates
 *
 * @author joann
 */
class Candidate { 
    private $candidateId;
    private $position;
    private $name;
    private $party;
    
    
    public function __construct($position, $name, $party, $candidateId=0){
        $this->candidateId = $candidateId;
        $this->position = $position;
        $this->name = $name;
        $this->party = $party;
    } 
    
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    public function insert(){
        $sql = "INSERT INTO candidates (position, name, party)"
               . " VALUES ('".$this->position."', '".$this->name."', '".$this->party."')";
        $conn = DatabaseManager::getConnection();
        $conn->query($sql);
        $id = $conn->insert_id;
        return $id;
    }
    
    public function getCandidateCode($candidateId = 0){
        if ($candidateId>0){
            $this->candidateId = $candidateId; 
        }
        return $this->position.'-'.$this->candidateId;
    }
    
}
