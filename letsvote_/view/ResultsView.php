<?php
include_once '../controller/ElectionController.php';
include_once '../model/ElectionData.php';
$positions = ElectionData::getAllPosition();
$candidates = ElectionData::getAllCandidates();
$results = ElectionData::getResults();
?>

<a href="../../xampp/urms/application/views/ClientView.php"></a>

<html>  
<head></head>  
<script type="text/javascript"  src="../js/jquery-1.12.4.js"></script>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css"></link>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css"></link>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-theme.css.map"></link>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css.map"></link>
    <link rel="stylesheet" type="text/css" href="../css/Common.css">
  
<body>  
    <?php if($positions != NULL && $candidates != NULL) {?>
    <div class="container container-table">
       <div class="row col-md-12 " >
           <table class="join" > 
            <tbody>
            <tr>
                <th colspan="3"><h2>Voting Results as of <?php echo date("m/d/y",time()).' '
                        .date(" H:i:s", time()); ?></h2></th>
            </tr>
            <form method="POST" id="votelistfrm" action="ElectionController.php">      
            <input type="hidden" name="action" id="action" value="voteNow"/>
            <?php 
            if(isset($positions)) { 
                foreach($positions as $position=>$value){
                    $type = $value->allowedVotes > 1 ? 'checkbox' : 'radio';?>
                <tr >
                    <input type="hidden" name="<?php echo $value->code.'-votes';?>" 
                           id="<?php echo $value->code.'-votes';?>"
                           value="<?php echo $value->allowedVotes; ?>"/>                
                    <td colspan="3"  class="td position"> <h3>For <?php echo $value->name;?></h3></td>
                    
                </tr>
                <?php                    
                    foreach(ElectionData::getCandidatesByPosition($value->code) as $candidateId){
                        $candidate = ElectionData::getCandidate($candidateId);?>
                    <tr>                        
                        <td width="40%"><?php echo $candidate->name?></td>
                        <td width="50%"><?php echo $candidate->party;?></td>
                        <td><?php echo $results[$candidateId]; ?></td>                        
                    </tr>                    
                    <?php } } } ?> 
                

            </form>
            </tbody>
        </table>
           <div class="row col-md-12" >
                <div class="row col-md-8 col-md-offset-2" >
                <input class="button" type="button" value="Vote Now" 
                    onclick="javascript:viewVoteNow();"/>
                </div>
            </div>
           <div class="row">
           </div>
        </div>
    </div>
    <?php } ?>
</body>  
</html>  

<script>    
    
    function viewVoteNow(){
        var form = document.getElementById('votelistfrm');
        form.submit();
    }
    
</script>