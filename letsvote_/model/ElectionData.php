<?php
include_once 'Position.php';
include_once 'Candidate.php';
include_once 'Result.php';
include_once '../controller/DatabaseManager.php';
/**
 * Description of ElectionData - Holds all the data for the election, including the position 
 * available and the list of candidates
 *
 * @author joann
 */
class ElectionData {
    
    private static $arr_position;
    private static $arr_candidates;
    private static $arr_results;
    
    public function __construct()    
    {   
        self::$arr_position = array();
        self::$arr_candidates = array();
        self::$arr_results = array();
    }
    
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    public function addPositionFromCSV($data){
        $position = new Position();
        $position->code = $data[1];
        $position->name = $data[2];
        $position->allowedVotes = intval($data[3]);
        $position->insert();
        self::$arr_position[$position->code] = $position;
    }        
    
    public function addCandidateFromCSV($data){
        $candidate = new Candidate($data[0], $data[1], $data[2]);    
        if (array_key_exists($data[0],  self::$arr_position)){
            $id = $candidate->insert();
            if($id){
                $result = new Result($candidate->getCandidateCode($id));
                $result->insert();
            }
        }
    }
    
    public function refreshElectionData(){
        DatabaseManager::executeSql("DELETE FROM results"); 
        DatabaseManager::executeSql("DELETE FROM candidates"); 
        DatabaseManager::executeSql("DELETE FROM positions"); 
    }
    
    public function addVote($id){
        $result = new Result($id);
        $result->updateVote();
    }
    
    public static function getAllPosition(){
        $sql = "SELECT * FROM positions ORDER BY id";
        $result = DatabaseManager::executeSql($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
               $position = new Position();
               $position->code = $row["positionCode"];
               $position->name =  $row["positionName"];
               $position->allowedVotes =  $row["allowedVotes"];
               self::$arr_position[$position->code] = $position;
            }
        }
        return self::$arr_position;
    }
    
    public static function getAllCandidates(){
        $sql = "SELECT * FROM candidates";
        $result = DatabaseManager::executeSql($sql);    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
               $candidate = new Candidate($row["position"], $row["name"], $row["party"], $row['id']);
               self::$arr_candidates[$candidate->getCandidateCode()] = $candidate;
            }
        }
        return self::$arr_candidates;
    }
    
    public static function getResults(){
        $sql = "SELECT * FROM results";
        $results = DatabaseManager::executeSql($sql);    
        if ($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
               self::$arr_results[$row['candidateid']] = $row['votes'];
            }
        }
        return self::$arr_results;
    }
    
    
    public static function getCandidate($id){
        if(array_key_exists($id, self::$arr_candidates)){
            return self::$arr_candidates[$id];
        }else{
            return NULL;
        }
    }
    
    public static function getCandidatesByPosition($positionId){
        $keys = array_keys(self::$arr_candidates);
        return preg_grep('/(^'.$positionId.'-)/', $keys);
    }
    
    
    
   
}
