<?php
include_once '../model/ElectionData.php';

/**
 * Description of FileReader - Reads and write the/to CSV file
 *
 * @author joann
 */
class FileManager {
    
    public function __construct(){    
    }     

    public function readCSVfile($electiondata){  
        if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1024, ",")) !== FALSE) {
                if($data[0] == 'PositionDetail'){                    
                    $electiondata->addPositionFromCSV($data);
                }else{
                    $electiondata->addCandidateFromCSV($data);
                }                
            }
            fclose($handle);
        }
    }
    
}


