<?php
require_once '../controller/DatabaseManager.php';


/**
 * Description of Result - Strores votes result per candidate
 *
 * @author joann
 */
class Result {
    private $candidateId;
    private $votes;
    
    public function __construct($id)    
    { 
        $this->candidateId = $id;
        $this->votes = 0;
    }
    
    public function insert(){
        $sql = "INSERT INTO results (candidateid)"
               . " VALUES ('".$this->candidateId."')";
        DatabaseManager::executeSql($sql);
    }
    
    public function updateVote(){
         $sql = "UPDATE results SET votes = votes+1 WHERE candidateid = '" .$this->candidateId. "'";
         DatabaseManager::executeSql($sql);
    }
}
