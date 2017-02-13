<?php
include_once '../controller/ElectionController.php';
include_once '../model/ElectionData.php';
$positions = ElectionData::getAllPosition();
$candidates = ElectionData::getAllCandidates();
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
           <table class="join"> 
            <tbody>
            <tr>
                <th colspan="3"><h2>You may now cast your votes.</h2></th>
            </tr>
            <form method="POST" id="votelistfrm" action="ElectionController.php">        
            <input type="hidden" name="votes" id="votes" value=""/>
            <input type="hidden" name="action" id="action" value=""/>
            <?php 
            if(isset($positions)) { 
                foreach($positions as $position=>$value){
                    $type = $value->allowedVotes > 1 ? 'checkbox' : 'radio';?>
                <tr >
                    <input type="hidden" name="<?php echo $value->code.'-votes';?>" 
                           id="<?php echo $value->code.'-votes';?>"
                           value="<?php echo $value->allowedVotes; ?>"/>                
                    <td colspan="2"  class="td position">
                        <h3>For <?php echo $value->name;?></h3></td>
                    <td colspan="1" class="td position" style="font-style: italic">
                        Please vote for at most <?php echo $value->allowedVotes;?></td>
                </tr>
                <?php                    
                    foreach(ElectionData::getCandidatesByPosition($value->code) as $candidateId){
                        $candidate = ElectionData::getCandidate($candidateId);?>
                    <tr>                        
                        <td width="10"><input type="<?php echo $type;?>"
                            name="<?php echo $value->code;?>"
                            id="<?php echo $value->code;?>"
                            value=<?php echo $candidateId;?>
                            /></td>
                        <td width="40%"><?php echo $candidate->name?></td>
                        <td width="50%"><?php echo $candidate->party;?></td>
                        
                    </tr>                    
                    <?php } } } ?> 
                

            </form>
            </tbody>
        </table>
           <div class="row col-md-12" >
                <div class="row col-md-6" >
                <input class="button" type="button" value="Cast Vote Now" 
                    onclick="javascript:voteNow();"/>
                </div>
                <div class="row col-md-6" >
                <input class="button"  type="button" value="View Results" 
                    onclick="javascript:viewResults();"/>
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
    function getSelectedValue(form, name, type) {
        var val = '';
        var input = form.elements[name];
        
        if (type === 'radio'){
            val = input.value + ';';
        }else{
            var count = 0;
            name = name + '-votes';
            var inputallowedvotes = form.elements[name].value;
            for (var i=0, len=input.length; i<len; i++) {
                if ( input[i].checked ) {                
                    val = val + input[i].value + ';';
                    count = count + 1;
                }
            }
            if (count > inputallowedvotes){
                alert ('Please select at most ' + inputallowedvotes + ' votes');
                return;
            }
        }
        return val; 
    }
        
    
    function voteNow(){
        var selected = '';
        <?php foreach($positions as $position=>$value){ ?>
            var position = <?php echo '\''.$value->code.'\'';?>;
            var posform = document.getElementById(position);
            var votes = getSelectedValue(document.getElementById('votelistfrm'), position, 
                            posform.type);
            if (!votes){
                return;
            }else{
                selected = selected + votes;             
            }
        <?php } ?>
            
        var form = document.getElementById('votelistfrm');
        form.action.value = 'castvote';
        form.votes.value = selected;
        form.submit();

    }
    
    function viewResults(){
        var form = document.getElementById('votelistfrm');
        form.action.value = 'viewResults';
        form.submit();
    }
</script>