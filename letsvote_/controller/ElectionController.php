<?php
session_start();
require_once '../controller/FileManager.php';


/**
 * Description of ElectionController - Controls all activities
 *
 * @author joann
 */
class ElectionController {
    private static $electiondata;
    
    public function __construct()    
    {   
        if(!isset(self::$electiondata)){
            self::$electiondata = new ElectionData();
        }
    }
    
    public function processCSVFile($overwrite = true){
        $fileReader = new FileManager();
        if ($overwrite){
            self::$electiondata = null;
            self::$electiondata = new ElectionData();
            self::$electiondata->refreshElectionData();
        }
        $fileReader->readCSVfile(self::$electiondata);
        return 'CandidateListView.php';
    }
    
    public function castVotes($arr_votes){
        foreach($arr_votes as $vote){
            if (trim($vote)===""){
                continue;
            }else{
                self::$electiondata->addVote($vote);
            }
        }        
    }
    
    public function tallyVotes(){
        $positions = self::$electiondata->positions;            
        foreach($positions->arr_position as $position=>$value){
            echo $value->code;
        }
    }
    
    public function displayElectionResult(){
        
    }
    
}


$page = '';
$action = '';
if (isset($_POST['action'])){
    $action = $_POST['action'];
}
$electionActs = new ElectionController();

if ($action == 'uploadcsv'){
    $page = $electionActs->processCSVFile();    
}else if ($action == 'castvote'){
    if (isset($_POST['votes'])){
        $votes = rtrim( $_POST['votes'], ";") ;
        $arr_votes = explode(";", $votes);
        $electionActs->castVotes($arr_votes);
        $page = '../view/ResultsView.php';
    }
}else if ($action == 'viewResults'){
    $page = '../view/ResultsView.php';
}else if ($action == 'voteNow'){
    $page = '../view/CandidateListView.php';
}

include('../view/'.$page);


